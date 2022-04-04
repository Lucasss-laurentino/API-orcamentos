@extends('layout.layout')


@section('content')

<div class="container d-flex justify-content-center">
    <div class="row mt-5">
        <div class="col-12 mt-3">
            <h1 class="text-center">{{ $orcamento['plano'] }}</h1>
            <table class="table transparente mt-4" style="height: 250px;">
                <thead>
                    <tr>
                        <th scope="col" class="p-2"><h3>Nome</h3></th>
                        <th scope="col" class="p-2"><h3>Idade</h3></th>
                        <th scope="col" class="p-2"><h3>Individual</h3></th>
                        <th scope="col" class="p-2"><h3>Total</h3></th>
                    </tr>
                </thead>
                <tbody>
                @for($contador = 0; $contador < count($orcamento['nomes']); $contador ++)
                    <tr>
                        <td class="p-2 pb-0"><h6>{{ $orcamento['nomes'][$contador] }}</h6></td>
                        <td class="p-2 text-center"><h6>{{ $orcamento['idades'][$contador] }}</h6></td>
                        <td class="p-2 text-center"><h6>R$ {{ $orcamento['individual'][$contador] }}</h6></td>
                @endfor
                        <td class="p-2 text-center"><h6>R$ {{ $orcamento['total'] }}</h6></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <a href="/" class="text-danger">Voltar a página inicial</a>
            </div>
        </div>
    </div>
</div>

@endsection