<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        try {
            $stores = Store::get();

            return response([
                'stores' => $stores,
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
            'name' => 'required|max:40|min: 3',
            'email' => 'required|email'],
            ['name.required' => 'O campo nome é obrigatório',
                'name.max' => 'O campo nome deve ter no máximo 40 caracteres',
                'name.min' => 'O campo nome deve ter no minimo 3 caracteres',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'Adicione o e-mail válido']);

        DB::beginTransaction();
        try {
            Store::create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            DB::commit();
            return response([
                'message' => 'Loja cadastrada com sucesso!',
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
            $store = Store::where('id', $id)->get();

            return response([
                'store' => $store,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|max:40|min: 3',
            'email' => 'required|email'],
            ['name.required' => 'O campo nome é obrigatório',
                'name.max' => 'O campo nome deve ter no máximo 40 caracteres',
                'name.min' => 'O campo nome deve ter no minimo 3 caracteres',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'Adicione o e-mail válido']);

        DB::beginTransaction();
        try {
            Store::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            DB::commit();
            return response([
                'message' => 'Loja alterada com sucesso!',
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
            Store::where('id', $id)->delete();

            DB::commit();
            return response([
                'message' => 'Loja deletada com sucesso!',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }


}
