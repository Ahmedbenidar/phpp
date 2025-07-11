@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
<div class="container" style="display: flex; gap: 40px;">
    <div>
        <h2>Votre relevé bancaire</h2>
        @if($client->releve_bancaire)
            @php
                $isPdf = \Illuminate\Support\Str::endsWith($client->releve_bancaire, '.pdf');
                $fileUrl = asset('storage/releves_bancaires/' . $client->releve_bancaire);
            @endphp

            @if($isPdf)
                <iframe src="{{ $fileUrl }}" width="400" height="600" style="border:none;"></iframe>
            @else
                <img src="{{ $fileUrl }}" alt="Relevé bancaire" style="max-width:400px;">
            @endif
        @else
            <p>Aucun relevé bancaire n'a été téléchargé.</p>
        @endif
    </div>
    <div>
        <h3>Tableau des transactions</h3>
        @if(isset($raw_lines))
            <h3>Lignes extraites du relevé (debug)</h3>
            <pre>
@foreach($raw_lines as $l)
{{ $l }}
@endforeach
            </pre>
        @endif
        @if(count($transactions))
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Débit</th>
                        <th>Crédit</th>
                        <th>Solde</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                        <tr>
                            <td>{{ $t['date'] }}</td>
                            <td>{{ $t['description'] }}</td>
                            <td>{{ $t['debit'] }}</td>
                            <td>{{ $t['credit'] }}</td>
                            <td>{{ $t['solde'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Aucune transaction trouvée.</p>
        @endif
    </div>
</div>
@endsection
