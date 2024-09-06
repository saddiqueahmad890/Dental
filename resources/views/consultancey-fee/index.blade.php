@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">@lang('Consultancy Fees')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Consultancy Fee List')</h3>
                </div>
                <div class="card-body">


                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>@lang('Name')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consultancies as $consultanceyFee)
                                <tr>


                                    <td><span style="text-wrap:nowrap;">{{ $consultanceyFee->user->name ?? '-' }}</span></td>
                                    <td>{{ $consultanceyFee->description }}</td>
                                    <td>{{ $consultanceyFee->amount }}</td>
                                    <td>{{ $consultanceyFee->created_at ? \Carbon\Carbon::parse($consultanceyFee->created_at)->format('d-M-Y') : '-' }}</td>

                                    <td class="responsive-width">
                                        <a href="{{ route('consultancey-fees.show', $consultanceyFee) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('View')"><i
                                                class="fa fa-eye ambitious-padding-btn"></i></a>

                                            <a href="{{ route('consultancey-fees.edit', $consultanceyFee) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                                title="@lang('Edit')"><i
                                                    class="fa fa-edit ambitious-padding-btn"></i></a>

                                            <a href="#"
                                                data-href="{{ route('consultancey-fees.destroy', $consultanceyFee) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                                data-target="#myModal" title="@lang('Delete')"><i
                                                    class="fa fa-trash ambitious-padding-btn"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $consultancies->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
