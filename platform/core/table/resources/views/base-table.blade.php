<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('tables.uploadfile') }}" enctype="multipart/form-data">
            @csrf
          <p>Please Upload the excel file here.</p>
          <div class="form-group">
            <input type="file" class="form-control" id="Excelfile" name="Excelfile" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="table-wrapper">
    @if ($table->isHasFilter())
        <div class="table-configuration-wrap" @if (request()->has('filter_table_id')) style="display: block;" @endif>
            <span class="configuration-close-btn btn-show-table-options"><i class="fa fa-times"></i></span>
            {!! $table->renderFilter() !!}
        </div>
    @endif
    <div class="portlet light bordered portlet-no-padding">
        <div class="portlet-title">
            <div class="caption">
                <div class="wrapper-action">
                    @if ($actions)
                        <div class="btn-group">
                            <a class="btn btn-secondary dropdown-toggle" href="#" data-toggle="dropdown">{{ trans('core/table::table.bulk_actions') }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($actions as $action)
                                    <li>
                                        {!! $action !!}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($table->isHasFilter())
                        <button class="btn btn-primary btn-show-table-options">{{ trans('core/table::table.filters') }}</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive @if ($actions) table-has-actions @endif @if ($table->isHasFilter()) table-has-filter @endif">
                @section('main-table')
                    {!! $dataTable->table(compact('id', 'class'), false) !!}
                @show
            </div>
        </div>
    </div>
</div>
@include('core/table::modal')

@push('footer')
    {!! $dataTable->scripts() !!}
@endpush
