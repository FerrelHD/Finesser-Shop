<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * Display search results page
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        $minPrice = $request->get('min_price', '');
        $maxPrice = $request->get('max_price', '');
        $sortBy = $request->get('sort', 'title');
        $sortOrder = $request->get('order', 'asc');
        $featured = $request->get('featured', false);
        $bundling = $request->get('bundling', false);

        $produks = $this->buildSearchQuery($query, $category, $minPrice, $maxPrice, $sortBy, $sortOrder, $featured, $bundling);
        
        // Get unique categories for filter
        $categories = Produk::where('is_active', true)
            ->distinct()
            ->pluck('file_type')
            ->filter()
            ->values();

        return view('search.results', compact('produks', 'query', 'category', 'minPrice', 'maxPrice', 'sortBy', 'sortOrder', 'featured', 'bundling', 'categories'));
    }

    /**
     * AJAX search for real-time results
     */
    public function ajaxSearch(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        if (strlen($query) < 2) {
            return response()->json(['results' => [], 'suggestions' => []]);
        }

        $produks = Produk::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('tags', 'LIKE', "%{$query}%")
                  ->orWhere('file_type', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get(['id', 'title', 'preview_image', 'price', 'file_type']);

        // Get search suggestions
        $suggestions = $this->getSearchSuggestions($query);

        return response()->json([
            'results' => $produks,
            'suggestions' => $suggestions,
            'total' => $produks->count()
        ]);
    }

    /**
     * Get search suggestions for autocomplete
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = $this->getSearchSuggestions($query);
        
        return response()->json($suggestions);
    }

    /**
     * Build search query with filters
     */
    private function buildSearchQuery($query, $category, $minPrice, $maxPrice, $sortBy, $sortOrder, $featured, $bundling)
    {
        $produks = Produk::where('is_active', true);

        // Search query
        if (!empty($query)) {
            $produks->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('tags', 'LIKE', "%{$query}%")
                  ->orWhere('file_type', 'LIKE', "%{$query}%");
            });
        }

        // Category filter
        if (!empty($category)) {
            $produks->where('file_type', $category);
        }

        // Price range filter
        if (!empty($minPrice)) {
            $produks->where('price', '>=', $minPrice);
        }
        if (!empty($maxPrice)) {
            $produks->where('price', '<=', $maxPrice);
        }

        // Featured filter
        if ($featured) {
            $produks->where('is_featured', true);
        }

        // Bundling filter
        if ($bundling) {
            $produks->where('is_bundling', true);
        }

        // Sorting
        $allowedSortFields = ['title', 'price', 'created_at', 'is_featured'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'title';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        return $produks->orderBy($sortBy, $sortOrder)->paginate(12);
    }

    /**
     * Get search suggestions for autocomplete
     */
    private function getSearchSuggestions($query)
    {
        $suggestions = [];

        // Get product titles
        $titles = Produk::where('is_active', true)
            ->where('title', 'LIKE', "%{$query}%")
            ->pluck('title')
            ->take(5);

        // Get categories
        $categories = Produk::where('is_active', true)
            ->where('file_type', 'LIKE', "%{$query}%")
            ->distinct()
            ->pluck('file_type')
            ->take(3);

        // Get tags
        $tags = Produk::where('is_active', true)
            ->where('tags', 'LIKE', "%{$query}%")
            ->pluck('tags')
            ->take(3);

        $suggestions = [
            'titles' => $titles,
            'categories' => $categories,
            'tags' => $tags
        ];

        return $suggestions;
    }
} 