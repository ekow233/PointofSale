<div class="modal fade" id="modal-branch" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_produk" class="col-lg-2 col-lg-offset-1 control-label">Name</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" disabled required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_kategori" class="col-lg-2 col-lg-offset-1 control-label">Category</label>
                        <div class="col-lg-6">
                            <select name="id_kategori" id="id_kategori" class="form-control" disabled required>
                                <option value="">Select Category</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="merk" class="col-lg-2 col-lg-offset-1 control-label">Brand</label>
                        <div class="col-lg-6">
                            <input type="text" name="merk" id="merk" class="form-control" disabled>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="stok" class="col-lg-2 col-lg-offset-1 control-label">Total Product Stock</label>
                        <div class="col-lg-6">
                            <input type="number" name="stok" id="stok" class="form-control" disabled required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div>
                            <button type="button" onClick="showDistribution()" class="btn btn-sm btn-flat btn-success" > <i class="fa fa-info-circle"></i> View Distribution Detail</button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stok" class="col-lg-2 col-lg-offset-1 control-label">Transfer Stock</label>
                        <div class="col-lg-6">
                            <input type="number" name="stok" id="stok" class="form-control" required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_kategori" class="col-lg-2 col-lg-offset-1 control-label">Branch</label>
                        <div class="col-lg-6">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-success"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Distribution Modal -->
<div class="modal fade" id="modal-distribution" tabindex="-1" role="dialog" aria-labelledby="modal-distribution">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Distribution Details</h4>
            </div>
            <div class="modal-body">
            <div class="table-responsive">
    <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 8px;">Product</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Branch</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Stock Transfered</th>
            </tr>
        </thead>
        <tbody id="distributionTable">
            
        </tbody>
    </table>
</div>

            </div>
        </div>
    </div>
</div>