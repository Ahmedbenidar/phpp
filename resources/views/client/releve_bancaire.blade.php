@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Colonne du document original -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-file-invoice me-2"></i>Relevé Bancaire Original
                        </h5>
                        <span class="badge bg-light text-primary">Document</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($client->releve_bancaire)
                        @php
                            $isPdf = Str::endsWith($client->releve_bancaire, '.pdf');
                            $fileUrl = asset('storage/releves_bancaires/' . $client->releve_bancaire);
                        @endphp

                        @if($isPdf)
                            <div class="ratio ratio-4x3">
                                <iframe src="{{ $fileUrl }}#toolbar=0&navpanes=0" class="rounded-bottom"></iframe>
                            </div>
                        @else
                            <img src="{{ $fileUrl }}" class="img-fluid rounded-bottom" alt="Relevé bancaire" style="max-height: 600px; width: 100%; object-fit: contain;">
                        @endif
                    @else
                        <div class="text-center p-5 bg-light">
                            <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun relevé bancaire n'a été téléchargé.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne des transactions -->
        <div class="col-lg-7">
            <form method="POST" action="{{ route('client.saveManualTransactions', $client->id) }}">
                @csrf
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2"></i>Transactions Extraites
                        </h5>
                        <button type="submit" class="btn btn-light btn-sm">Enregistrer les modifications</button>
                    </div>
                    <div class="card-body">
                        @if(count($transactions))
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-nowrap">Date</th>
                                            <th>Description</th>
                                            <th class="text-end text-nowrap">Débit (€)</th>
                                            <th class="text-end text-nowrap">Crédit (€)</th>
                                            <th class="text-end text-nowrap">Solde (€)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $index => $t)
                                        <tr>
                                            <td class="text-nowrap">
                                                <input type="text" name="transactions[{{ $index }}][date]" value="{{ $t['date'] }}" class="form-control form-control-sm" />
                                            </td>
                                            <td>
                                                <input type="text" name="transactions[{{ $index }}][description]" value="{{ $t['description'] }}" class="form-control form-control-sm" />
                                            </td>
                                            <td class="text-end">
                                                <input type="text" name="transactions[{{ $index }}][debit]" value="{{ $t['debit'] }}" class="form-control form-control-sm text-end" />
                                            </td>
                                            <td class="text-end">
                                                <input type="text" name="transactions[{{ $index }}][credit]" value="{{ $t['credit'] }}" class="form-control form-control-sm text-end" />
                                            </td>
                                            <td class="text-end">
                                                <input type="text" name="transactions[{{ $index }}][solde]" value="{{ $t['solde'] }}" class="form-control form-control-sm text-end" />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                    <div>
                                        <h5 class="alert-heading">Aucune transaction trouvée</h5>
                                        <p class="mb-0">Le système n'a pas pu extraire de transactions depuis ce relevé.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Section Debug -->
                        @if(isset($raw_lines))
                            <div class="mt-4">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#debugSection">
                                    <i class="fas fa-code me-1"></i> Afficher les données brutes
                                </button>
                                <div id="debugSection" class="collapse mt-3">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Lignes extraites du relevé (debug)</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <pre class="p-3 mb-0 bg-light" style="max-height: 300px; overflow: auto;">@foreach($raw_lines as $l){{ $l }}
@endforeach</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
    }
    .table th {
        white-space: nowrap;
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
    }
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .ratio-4x3 {
        --bs-aspect-ratio: 75%;
    }
</style>
@endsection