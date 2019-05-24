
 <div style="margin:15px;">
            <table style="width:100%;">
                <tr>
                    <td style="width:33%;" valign="top">
                        <p>Order No. <span style="color:#86152c;">{{$data[0]['id']}}</span><br />
                            Order Date <span style="color:#86152c;">{{$data[0]['created_at']}}</span>
                        </p>
                    </td>
                    <td style="width:33%;" valign="top">
                        <img src="" style="width:100px;display:block;margin:0px auto;margin-left:70px;margin-top:-5px;" />
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
                       
                         {{$data[0]['firstname']}} {{$data[0]['lastname']}} <br/>
                         {{$data[0]['address1']}}<br/>
                         {{$data[0]['city']}}<br/>
                         {{$data[0]['postcode']}}<br/>
                         {{$data[0]['country']}}

                        </p>
            

                        <p>
                            {{$data[0]['email']}}<br/>
                            {{$data[0]['telephone']}}
                        </p>
                    </td>
                    <td style="width:50%;" valign="top">
                        <p><span style="color:#86152c;">Delivery Address</span></p>

                     <p>
                         {{$data[0]['firstname']}} {{$data[0]['lastname']}} <br/>
                         {{$data[0]['address1']}}<br/>
                         {{$data[0]['city']}}<br/>
                         {{$data[0]['postcode']}}<br/>
                         {{$data[0]['country']}}
                        </p>

                        <p>
                               {{$data[0]['email']}}<br />
                            {{$data[0]['telephone']}}
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

            
             @if ($data[0]['pet_upgrade_id'] != "") 
               
                <table style="width:100%;">
                    <tr>
                        <td style="width:15%;" valign="top">
                            <p>{{ $order->pet_upgrade_id }}</p>
                        </td>
                        <td style="width:55%;" valign="top">
                            <p>Pet Upgrade</p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>1</p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>£ {{ $data->totalPaid, 2 }}</p>
                        </td>
                        <td style="width:10%;" valign="top">
                            <p>£ {{ $data->totalPaid, 2 }}</p>
                        </td>
                    </tr>
                </table>
                <br />
            @endif
    
             @foreach ($Item as $key => $Items)
             
               <table style="width:100%;">
                        <tr>
                            <td style="width:15%;" valign="top">
                                <p>{{ $Items->id }}</p>
                            </td>
                            <td style="width:55%;" valign="top">
                                <p>{{ $Items->name }}</p>  
                            </td>
                            <td style="width:10%;" valign="top">
                               
                            </td>
                            <td style="width:10%;" valign="top">
                                <p>£ {{$Items->price, 2 }}</p>
                            </td>
                            <td style="width:10%;" valign="top">
                              
                            </td>
                        </tr>
                    </table>
           @endforeach

            <br />
            <br />
            <table style="width:100%;">
                <tr>
                    <td style="width:15%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:55%;" valign="top">
                        <p>Delivery {{ $data[0]['shipping_title'] }}</p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p></p>
                    </td>
                    <td style="width:10%;" valign="top">
                        <p>£ {{$data[0]['shipping_cost'], 2 }} </p>
                    </td>
                </tr>
            </table>
            <br />
           
           {{ $vat = $data[0]['vat_rate'] }} 
            {{ $vatToPay = (($data[0]['order_amount']-$data[0]['shipping_cost']) / 100) * $vat }}
          
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
                        <p>£{{$vatToPay, 2 }}</p>
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
                        <p><span style="color:#86152c;">£ {{ $data[0]['order_amount'], 2 }} </span></p>
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