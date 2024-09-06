@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('insurance-providers.create') }}" class="btn btn-outline btn-info">
                            + @lang('Create Insurance')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('All Insurances')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Insurances')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Phone')</th>
                                {{-- <th>@lang('Website')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('Rating')</th> --}}
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach ($insuranceProviders as $insuranceProvider)
                                <tr>
                                    <td><span style="text-wrap:nowrap;">{{ $insuranceProvider->name }}</span></td>
                                    <td>{{ $insuranceProvider->email }}</td>
                                    <td>{{ $insuranceProvider->phone }}</td>
                                    {{-- <td>{{ $insuranceProvider->website }}</td>
                                    <td>{{ $insuranceProvider->address }}</td>
                                    <td>{{ $insuranceProvider->rating }}</td> --}}
                                    <td class="responsive-width">
                                        <a href="{{ route('insurance-providers.show', $insuranceProvider) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg align-content-center" data-toggle="tooltip"
                                            title="@lang('View')"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('insurance-providers.edit', $insuranceProvider) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg align-content-center" data-toggle="tooltip"
                                            title="@lang('Edit')"><i class="fa fa-edit"></i></a>
                                        @can('insurance-providers-delete')
                                            <form action="{{ route('insurance-providers.destroy', $insuranceProvider) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-info btn-outline btn-circle btn-lg align-content-center"
                                                    data-toggle="tooltip" title="@lang('Delete')">
                                                    <i class="fa fa-trash ambitious-padding-btn"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $insuranceProviders->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
