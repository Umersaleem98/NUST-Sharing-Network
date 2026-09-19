<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class BeneficiaryProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Available Products
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $productsQuery = Product::query()
            ->with('category')
            ->where('status', 'active');

        if ($request->filled('category_id')) {
            $productsQuery->where(
                'category_id',
                $request->input('category_id')
            );
        }

        if ($request->filled('search')) {
            $search = trim(
                (string) $request->input('search')
            );

            if ($search !== '') {
                $productsQuery->whereAny(
                    [
                        'name',
                        'description',
                    ],
                    'like',
                    '%' . $search . '%'
                );
            }
        }

        $products = $productsQuery
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view(
            'pages.beneficiary.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Product Details
    |--------------------------------------------------------------------------
    */
    public function show(int $id): View
    {
        $product = Product::query()
            ->with('category')
            ->findOrFail($id);

        $requestExists = ProductRequest::query()
            ->where('product_id', $product->id)
            ->where('beneficiary_id', Auth::id())
            ->exists();

        $relatedProducts = Product::query()
            ->with('category')
            ->where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(6)
            ->get();

        return view(
            'pages.beneficiary.products.show',
            compact(
                'product',
                'requestExists',
                'relatedProducts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Submit Product Request
    |--------------------------------------------------------------------------
    */
    public function sendRequest(int $id): RedirectResponse
    {
        $product = Product::query()
            ->findOrFail($id);

        if ($product->status !== 'active') {
            return back()->with(
                'error',
                'This product is currently unavailable and cannot be requested.'
            );
        }

        $requestAlreadyExists = ProductRequest::query()
            ->where('product_id', $product->id)
            ->where('beneficiary_id', Auth::id())
            ->exists();

        if ($requestAlreadyExists) {
            return back()->with(
                'error',
                'You have already submitted a request for this product.'
            );
        }

        try {
            $productRequest = new ProductRequest();

            $productRequest->beneficiary_id =
                Auth::id();

            $productRequest->product_id =
                $product->id;

            $productRequest->donor_id =
                $product->user_id;

            $productRequest->status =
                'pending';

            $productRequest->admin_status =
                'pending';

            $productRequest->donor_status =
                'pending';

            $productRequest->donor_information_allowed =
                false;

            $productRequest->save();

        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Your request could not be submitted. Please try again.'
            );
        }

        return redirect()
            ->route('beneficiary.my.requests')
            ->with(
                'success',
                'Your product request was submitted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Beneficiary Request History
    |--------------------------------------------------------------------------
    */
    public function myRequests(): View
    {
        $beneficiaryId =
            Auth::id();

        $requests = ProductRequest::query()
            ->with([
                'product.category',
            ])
            ->where(
                'beneficiary_id',
                $beneficiaryId
            )
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Secure Donor Information Loading
        |--------------------------------------------------------------------------
        */
        foreach ($requests as $productRequest) {
            $adminAllowed =
                $productRequest->admin_status ===
                'approved';

            $donorAccepted =
                in_array(
                    $productRequest->donor_status,
                    [
                        'accepted',
                        'approved',
                    ],
                    true
                );

            $informationAllowed =
                (bool) (
                    $productRequest->donor_information_allowed
                    ?? false
                );

            if (
                $adminAllowed
                && $donorAccepted
                && $informationAllowed
            ) {
                $productRequest->loadMissing([
                    'donor.donorProfile',
                ]);
            } else {
                $productRequest->unsetRelation(
                    'donor'
                );
            }
        }


        $requestStats = [
            'total' =>
                ProductRequest::query()
                    ->where(
                        'beneficiary_id',
                        $beneficiaryId
                    )
                    ->count(),

            'admin_pending' =>
                ProductRequest::query()
                    ->where(
                        'beneficiary_id',
                        $beneficiaryId
                    )
                    ->where(
                        'admin_status',
                        'pending'
                    )
                    ->count(),

            'awaiting_donor' =>
                ProductRequest::query()
                    ->where(
                        'beneficiary_id',
                        $beneficiaryId
                    )
                    ->where(
                        'admin_status',
                        'approved'
                    )
                    ->where(
                        'donor_status',
                        'pending'
                    )
                    ->count(),

            'accepted' =>
                ProductRequest::query()
                    ->where(
                        'beneficiary_id',
                        $beneficiaryId
                    )
                    ->whereIn(
                        'donor_status',
                        [
                            'accepted',
                            'approved',
                        ]
                    )
                    ->count(),

            'rejected' =>
                ProductRequest::query()
                    ->where(
                        'beneficiary_id',
                        $beneficiaryId
                    )
                    ->whereAny(
                        [
                            'admin_status',
                            'donor_status',
                        ],
                        '=',
                        'rejected'
                    )
                    ->count(),
        ];

        return view(
            'pages.beneficiary.myrequest.index',
            compact(
                'requests',
                'requestStats'
            )
        );
    }
}
