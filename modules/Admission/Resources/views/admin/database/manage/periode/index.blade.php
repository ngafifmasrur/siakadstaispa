@extends('admission::admin.layouts.admin')

@section('subtitle', 'Periode Penerimaan - ')

@section('breadcrumb')
    <li class="breadcrumb-item">Periode Penerimaan</li>
    <li class="breadcrumb-item active">Data Periode Penerimaan</li>
@endsection

@section('section')
    <div class="section">
        <h3 class="mb-1">Kelola data Periode Penerimaan</h3>
        <div class="mb-2">Mengubah status periode.</div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-0 py-1"> Data Periode </h5>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Status Publish</th>
                                    <th>Ubah Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admission as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name.' '.$item->period->name }}</td>
                                        <td>{{ $item->period->year }}</td>
                                        <td>{{ $item->open ? 'Buka' : 'Tutup' }}</td>
                                        <td>{{ $item->published ? 'Published' : 'Unpublished' }}</td>
                                        <td class="py-2 align-middle border-left text-center" nowrap>
                                            @if ($item->open == 0)
                                                <button class="btn btn-success btn-sm btn_update" data-route="{{ route('admission.admin.database.manage.periode.update', ['periode' => $item->id, 'next' => request('next', url()->previous()) ]) }}"><i class="mdi mdi-check"></i></button>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted px-4">
                                            Tidak ada data periode
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="update_title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update_title">Periode aktif</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Jadikan periode ini aktif?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close
                </button>
                <button class="btn btn-success" type="button" id="btn_submit_delete" onclick="document.getElementById('form_update').submit();">
                    Aktifkan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','.btn_update',function(){
            let route = $(this).data('route');
            
            $('#form_update').attr('action',route);
            $('#ModalUpdate').modal('show');
        });
    });
</script>
@endsection