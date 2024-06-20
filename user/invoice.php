<div class="modal fade" id="invoice" aria-hidden="true" aria-labelledby="invoice" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoice">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-left:150px;">
                <!--                 
                    <div id="invoice_data">
                        <h1>Sample Invoice</h1>
                        <p>This is a sample invoice content.</p>
                    </div>
                 -->
                <div class="card p-3" id="invoice_data" style="width:80%; height:auto">
                    <div class=" d-flex justify-content-center">
                        <img src="../images/Logo1.png" style="width:80px; height:auto;">
                        <h4 class="py-3">Tee World Myanmar</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-secondary">
                            invoice_id : ##### <br>
                            user_name : ##### <br>
                            user_email : #### <br>
                            user_address : #### <br>
                        </p>
                        <p class="text-end text-secondary">
                            order_date
                        </p>
                    </div>
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order_id</th>
                                    <th scope="col">Product_id</th>
                                    <th scope="col">Product_name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td colspan="">Larry</td>
                                    <td>@twitter</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="fs-4 text-end pe-3">Total</td>
                                    <td>totalprice</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="fs-5">Contact Us</div>
                        <p>ph no <br>
                            address <br>
                            email
                        </p>
                    </div>
                    <div class="text-center">
                        <img src="../images/Thank_you.jpg" style="width:100px; height:auto;">
                    </div>
                </div>
                <!-- <div class="invoice-box" id="invoice_data">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td class="title">
                                            <h1>Invoice</h1>
                                        </td>
                                        <td>
                                            Invoice #: 123<br>
                                            Created: January 1, 2024<br>
                                            Due: February 1, 2024
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            Acme Corp.<br>
                                            John Doe<br>
                                            john@example.com
                                        </td>
                                        <td>
                                            Company Inc.<br>
                                            Jane Smith<br>
                                            jane@example.com
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="heading">
                            <td>Item</td>
                            <td>Price</td>
                        </tr>
                        <tr class="item">
                            <td>Website design</td>
                            <td>$300.00</td>
                        </tr>
                        <tr class="item last">
                            <td>Hosting (3 months)</td>
                            <td>$75.00</td>
                        </tr>
                        <tr class="total">
                            <td></td>
                            <td>Total: $375.00</td>
                        </tr>
                    </table>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-dark" id="download">Dowload invoice</button>
            </div>
        </div>
    </div>
</div>