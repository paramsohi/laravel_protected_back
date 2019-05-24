 <div style="margin:15px;">
            <table style="width:100%;">
                <tr>
                    <td style="width:33%;" valign="top">
                        <p>Order No. <span style="color:#86152c;"><?= $this->get["order"] ?></span><br />
                            Order Date <span style="color:#86152c;"><?= date('d/m/Y', strtotime($order->orderDate)) ?></span>
                        </p>
                    </td>
                    <td style="width:33%;" valign="top">
                        <img src="<?= SITE_URL ?>assets/img/logo.png" style="width:100px;display:block;margin:0px auto;margin-left:70px;margin-top:-5px;" />
                    </td>
                    <td style="width:33%;" valign="top">
                        <p style="text-align:right;"><br /><span style="color:#86152c;">Invoice</span>
                        </p>
                    </td>
                </tr>
            </table>
            <div style="height:1px;width:100%;background:#000000;margin-top:10px;"></div>

            <table style="width:100%;">
                <tr>
                    <td style="width:50%;" valign="top">
                        <p><span style="color:#86152c;">Billing Address</span></p>

                        <p>
                            <?= $order->firstname ?> <?= $order->lastname ?><br />
                            <?= $order->address1 ?><br />
                            <?php if($order->address2 != "") { ?>
                                <?= $order->address2 ?><br />
                            <?php } ?>
                            <?= $order->city ?><br />
                            <?= $order->postcode ?><br />
                            <?= $order->country ?>
                        </p>

                        <p>
                            <?= $order->email ?><br />
                            <?= $order->telephone ?>
                        </p>
                    </td>
                    <td style="width:50%;" valign="top">
                        <p><span style="color:#86152c;">Delivery Address</span></p>

                        <p>
                            <?= $order->firstname ?> <?= $order->lastname ?><br />
                            <?= $order->address1 ?><br />
                            <?php if($order->address2 != "") { ?>
                                <?= $order->address2 ?><br />
                            <?php } ?>
                            <?= $order->city ?><br />
                            <?= $order->postcode ?><br />
                            <?= $order->country ?>
                        </p>

                        <p>
                            <?= $order->email ?><br />
                            <?= $order->telephone ?>
                        </p>
                    </td>
                </tr>
            </table>

            <br />
            <br />
            <br />

            <table style="width:100%;">
                <tr>
                    <td style="width:15%;" valign="top">
                        <p><span style="color:#86152c;">Product No.</span></p>
                    </td>
                    <td style="width:55%;" valign="top">
                        <p><span style="color:#86152c;">Description</span></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p><span style="color:#86152c;">Qty</span></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p><span style="color:#86152c;">Price</span></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p><span style="color:#86152c;">Total</span></p>
                    </td>
                </tr>
            </table>

            <div style="height:1px;width:100%;background:#000000;margin-top:10px;"></div>

            <?php
            if($order->petUpgradeID != "") {
                ?>
                <table style="width:100%;">
                    <tr>
                        <td style="width:15%;" valign="top">
                            <p><?= $order->petUpgradeID ?></p>
                        </td>
                        <td style="width:55%;" valign="top">
                            <p>Pet Upgrade</p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>1</p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>£<?= number_format($order->totalPaid, 2) ?></p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>£<?= number_format($order->totalPaid, 2) ?></p>
                        </td>
                    </tr>
                </table>
                <br />
                <?php

            }
            ?>

            <?php
            foreach($items as $item) {
                $product = ORM::for_table("pet_product_live")->find_one($item->productID);

                if($product->PName != "") {
                    ?>
                    <table style="width:100%;">
                        <tr>
                            <td style="width:15%;" valign="top">
                                <p><?= $item->productID ?></p>
                            </td>
                            <td style="width:55%;" valign="top">
                                <p><?= $product->PName ?></p>
                            </td>
                            <td style="width:10%;" valign="top">
                                <p><?= $item->qty ?></p>
                            </td>
                            <td style="width:10%;" valign="top">
                                <p>£<?= number_format($item->price, 2) ?></p>
                            </td>
                            <td style="width:10%;" valign="top">
                                <p>£<?= number_format($item->qty*$item->price, 2) ?></p>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <?php
                }
            }
            ?>

            <br />
            <br />
            <table style="width:100%;">
                <tr>
                    <td style="width:15%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:55%;" valign="top">
                        <p>Delivery (<?= $order->shippingTitle ?>)</p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p>£<?= number_format($order->shippingCost, 2) ?></p>
                    </td>
                </tr>
            </table>
            <br />
            <?php
            $vat = $order->vatRate;
            $vatToPay = (($order->totalPaid-$order->shippingCost) / 100) * $vat;
            ?>
            <table style="width:100%;">
                <tr>
                    <td style="width:15%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:55%;" valign="top">
                        <p>VAT (20%)</p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p>£<?= number_format($vatToPay, 2) ?></p>
                    </td>
                </tr>
            </table>
            <br />
            <table style="width:100%;">
                <tr>
                    <td style="width:15%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:55%;" valign="top">
                        <p><span style="color:#86152c;">Total</span></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p><span style="color:#86152c;">£<?= number_format($order->totalPaid, 2) ?></span></p>
                    </td>
                </tr>
            </table>
            <br />


            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <p><span style="color:#86152c;">The Protected Pet Team</span></p>
            <div style="height:1px;width:100%;background:#000000;margin-top:10px;"></div>
            <table style="width:100%;">
                <tr>
                    <td style="width:50%;" valign="top">
                        <p><span style="color:#86152c;">Tel:</span> 0844 414 2262<br />
                            <span style="color:#86152c;">Email:</span> info@protectedpet.com
                        </p>


                    </td>
                    <td style="width:50%;" valign="top">
                        <p style="text-align:right;">
                            Unit B Barton Turn, Burton-Upon-Trent,<br />
                            Staffordshire DE13 8EB
                        </p>
                    </td>
                </tr>
            </table>



        </div>