<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Store;
use App\Product;


class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::get();

            return response([
                'products' => $products,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function productsStore($store_id)
    {
        try {
            $products = Product::where('store_id', $store_id)->get();

            return response([
                'products' => $products,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60|min:3',
            'value' => 'required|integer',
            'store_id' => 'required'],
            [
                'name.required' => 'O campo nome é obrigatório',
                'name.max' => 'O campo nome deve ter no máximo 60 caracteres',
                'name.min' => 'O campo nome deve ter no minimo 3 caracteres',
                'value.required' => 'O campo valor é obrigatório',
                'store_id.required' => 'Você deve informar o ID da loja',
                'value.integer' => 'O valor deve ser um número inteiro']);

        DB::beginTransaction();
        try {
            Product::create([
                'name' => $request->name,
                'value' => $request->value,
                'store_id' => $request->store_id,
            ]);

            DB::commit();
            return response([
                'message' => 'Produto cadastrado com sucesso!',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function show($id)
    {
        try {
            $product = Product::where('id', $id)->get();

            return response([
                'product' => $product,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            Product::where('id', $id)->update([
                'name' => $request->name,
                'value' =>  $request->value,
                'active' => $request->active,
            ]);

            DB::commit();
            return response([
                'message' => 'Produto alterado com sucesso!',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            Product::where('id', $id)->delete();

            DB::commit();
            return response([
                'message' => 'Produto deletado com sucesso!',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }


}
