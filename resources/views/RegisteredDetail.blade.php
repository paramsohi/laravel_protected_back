<div style="text-align:center;margin:15px;">
            
            <br />
            <br />
            <h2>Registered Owner Details</h2>

            <p style="font-size:17px;"><strong>Name:</strong>  {{$user_detail->firstname}} {{$user_detail->lastname}}</p>
            <p style="font-size:17px;"><strong>Address:</strong><br/>{{$user_detail->UserAddresses->street1}},<br/>{{$user_detail->UserAddresses->city}},<br/>{{$user_detail->UserAddresses->country}},<br/>{{$user_detail->UserAddresses->postcode}}</p>
            <p style="font-size:17px;"><strong>Phone Number:</strong>{{$user_detail->UserExtras->phone}}</p>
            <p style="font-size:17px;"><strong>Email Address:</strong> {{$user_detail->email}}</p>

            <br />
            <br />
            <h2>Registered Pet Details</h2>

            <p style="font-size:17px;"><strong>Chip Number:</strong> {{$pet_detail->chip_no_string}}</p>
            <p style="font-size:17px;"><strong>Name:</strong> {{$pet_detail->name}}</p>
            <p style="font-size:17px;"><strong>Breed:</strong> {{$pet_detail->breed}}</p>
            <p style="font-size:17px;"><strong>Colour:</strong> {{$pet_detail->colour}}</p>
            <p style="font-size:17px;"><strong>Sex:</strong> {{$pet_detail->sex}}</p>


        </div>