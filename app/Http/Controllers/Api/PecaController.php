<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PecaController extends Controller
{

    private function checkPermission(String $permission)
    {
        if(env('API_AUTH'))
        {
            if (! Auth::user()->tokenCan($permission)) {
                abort(401,'Permission denied');
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->checkPermission('read');

        $categoria = $request->get('categoria',null);

        $pecas = Peca::select('id','codigo','categoria','nome','created_at','updated_at');

        if (isset($categoria))
        {
            $pecas = $pecas->where('categoria',$categoria);
        }


        return [
            'count' => $pecas->count(),
            'data' => $pecas->get(),
        ];
    }

    /**
     * Display a listing of the resource deleted.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->checkPermission('read');

        $categoria = $request->get('categoria',null);

        $pecas = Peca::select('id','codigo','categoria','nome','created_at','updated_at')->onlyTrashed();

        if (isset($categoria))
        {
            $pecas = $pecas->where('categoria',$categoria);
        }


        return [
            'count' => $pecas->count(),
            'data' => $pecas->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkPermission('create');

        $validated = $request->validate([
            'codigo' => ['required','unique:pecas'],
            'categoria' => ['required'],
            'nome' => ['nullable'],
            'descricao' => ['nullable'],
        ]);

        $peca = Peca::create($validated);

        return $peca;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peca  $peca
     * @return \Illuminate\Http\Response
     */
    public function show(Peca $peca)
    {
        $this->checkPermission('read');
        return $peca;
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $codigo
     * @return \Illuminate\Http\Response
     */
    public function showByCode(String $codigo)
    {
        $peca = Peca::where('codigo',$codigo)->firstOrFail();
        return $this->show($peca);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peca  $peca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peca $peca)
    {
        $this->checkPermission('update');

        $validated = $request->validate([
            'codigo' => ['nullable',
                Rule::unique('pecas')->ignore($peca->id),
            ],
            'categoria' => ['nullable'],
            'nome' => ['nullable'],
            'descricao' => ['nullable'],
        ]);

        $validated = array_filter($validated);

        $peca->update($validated);

        return $peca;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $codigo
     * @return \Illuminate\Http\Response
     */
    public function updateByCode(Request $request, String $codigo)
    {
        $peca = Peca::where('codigo',$codigo)->firstOrFail();

        return $this->update($request,$peca);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peca  $peca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peca $peca)
    {
        $this->checkPermission('delete');
        $peca->delete();
        return $peca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $codigo
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode(String  $codigo)
    {
        $peca = Peca::where('codigo',$codigo)->firstOrFail();
        return $this->destroy($peca);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $peca_id
     * @return \Illuminate\Http\Response
     */
    public function restore(String $peca_id)
    {
        $this->checkPermission('delete');
        $peca = Peca::onlyTrashed()->findOrFail($peca_id);
        $peca->restore();
        return $peca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  String  $codigo
     * @return \Illuminate\Http\Response
     */
    public function restoreByCode(String  $codigo)
    {
        $peca = Peca::onlyTrashed()->where('codigo',$codigo)->firstOrFail();
        return $this->restore($peca->id);
    }



}
