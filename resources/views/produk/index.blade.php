@extends('layouts.master')

@section('title')
    Product List
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Product List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle"></i> Add New Product</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger  btn-flat"><i class="fa fa-trash"></i> Delete</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-warning  btn-flat"><i class="fa fa-barcode"></i> Print Barcode</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered table-hover">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Discount</th>
                            <th>Stock</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@includeIf('produk.branch')
@endsection

@push('scripts')
<script>
    let table;
    let distribution;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Unable to save data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Add Product');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Product');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Unable to display data');
                return;
            });
    }

    // distribution
    // function showDistribution() {
    //     console.log(distribution);
    //     $('#modal-distribution').modal('show');

    //     const tableDist = document.getElementById('distributionTable')

    //     distribution.forEach(item => {
    //         const row = document.createElement('tr');
    //         row.innerHTML = `
    //         <td style="border: 1px solid #ddd; padding: 8px;">${item.product}</td>
    //         <td style="border: 1px solid #ddd; padding: 8px;">${item.branch}</td>
    //         <td style="border: 1px solid #ddd; padding: 8px;">${item.stock}</td>`;

    //         tableDist.appendChild(row);
    //     })

        
    // }

//     function showDistribution() {
//     console.log(distribution);
//     $('#modal-distribution').modal('show');

//     const tableDist = document.getElementById('distributionTable');

//     // Clear existing rows in the table
//     $(document).on('hidden.bs.modal', '#modal-distribution', function () {
//         tableDist.innerHTML = '';
//     });

//     distribution.forEach(item => {
//         const row = document.createElement('tr');
//         row.innerHTML = `
//         <td style="border: 1px solid #ddd; padding: 8px;">${item.product}</td>
//         <td style="border: 1px solid #ddd; padding: 8px;">${item.branch}</td>
//         <td style="border: 1px solid #ddd; padding: 8px;">${item.stock}</td>`;

//         tableDist.appendChild(row);
//     });
// }

function showDistribution() {
    console.log(distribution);
    $('#modal-distribution').modal('show');

    const tableDist = document.getElementById('distributionTable');

    // Clear existing rows in the table
    $(document).on('hidden.bs.modal', '#modal-distribution', function () {
        tableDist.innerHTML = '';
    });

    if (distribution.length === 0) {
        const noDistributionRow = document.createElement('tr');
        const noDistributionCell = document.createElement('td');
        noDistributionCell.textContent = 'No distribution made yet to branch';
        noDistributionCell.colSpan = 3; // Span across all columns
        noDistributionCell.style.border = '1px solid #ddd'; // Border style
        noDistributionCell.style.padding = '8px'; // Padding
        noDistributionCell.style.textAlign = 'center'; // Center align the text
        noDistributionRow.appendChild(noDistributionCell);
        tableDist.appendChild(noDistributionRow);
    } else {
        distribution.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td style="border: 1px solid #ddd; padding: 8px;">${item.product}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">${item.branch}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">${item.stock}</td>`;
            tableDist.appendChild(row);
        });
    }
}




    function showBranch(url,url1) {
        console.log(url);
        console.log(url1);

        $('#modal-branch').modal('show');
        $('#modal-branch .modal-title').text('Product Distribution To Branch');

        $('#modal-branch form')[0].reset();
        $('#modal-branch form').attr('action', url);
        $('#modal-branch [name=_method]').val('put');
        $('#modal-branch [name=nama_produk]').focus();

        $.get(url1)
            .done((response) => {
                console.log(response);
                $('#modal-branch [name=nama_produk]').val(response.nama_produk);
                $('#modal-branch [name=id_kategori]').val(response.id_kategori);
                $('#modal-branch [name=merk]').val(response.merk);
                $('#modal-branch [name=harga_beli]').val(response.harga_beli);
                $('#modal-branch [name=harga_jual]').val(response.harga_jual);
                $('#modal-branch [name=diskon]').val(response.diskon);
                $('#modal-branch [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Unable to display data');
                return;
            });


            $.get(url)
            .done((response) => {
                console.log("stock url ",response);
                distribution = response
                
            })
            .fail((errors) => {
                alert('Unable to display data');
                return;
            });

    }

    function deleteData(url) {
        if (confirm('Are you sure you want to delete selected data?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Unable to delete data');
                    return;
                });
        }
    }

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Unable to delete data');
                        return;
                    });
            }
        } else {
            alert('Select the data to delete');
            return;
        }
    }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Select the data to print');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Select at least 3 data to print');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush