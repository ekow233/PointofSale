<!-- <div class="modal fade" id="modal-branch" tabindex="-1" role="dialog" aria-labelledby="modal-detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Branch form</h4>
            </div>
            <div class="modal-body">
          
                <table class="table table-striped table-bordered table-detail">
                    <thead>
                        <th width="5%">#</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div> -->


<div class="modal fade" id="modal-branch" tabindex="-1" role="dialog" aria-labelledby="modal-detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Branch form</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="process_form.php">
                    <div class="form-group">
                        <label for="product">Product:</label>
                        <select class="form-control" id="product" name="product" required>
                            <option value="">Select Product</option>
                            <option value="product1">Product 1</option>
                            <option value="product2">Product 2</option>
                            <option value="product3">Product 3</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="branch">Branch:</label>
                        <select class="form-control" id="branch" name="branch" required>
                            <option value="">Select Branch</option>
                            <option value="branch1">Branch 1</option>
                            <option value="branch2">Branch 2</option>
                            <option value="branch3">Branch 3</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
