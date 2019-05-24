<div style="text-align:center;margin:15px;">
            
            <br />
            <br />
            <h2>Pet Owner Details</h2>

            <p style="font-size:17px;"><strong>Name:</strong>  {{$user->firstname}} {{$user->lastname}}</p>
            <p style="font-size:17px;"><strong>Address:</strong><br/>{{$user->UserAddresses->street1}},<br/>{{$user->UserAddresses->city}},<br/>{{$user->UserAddresses->country}},<br/>{{$user->UserAddresses->postcode}}</p>
            <p style="font-size:17px;"><strong>Phone Number:</strong>{{$user->UserExtras->phone}}</p>
            <p style="font-size:17px;"><strong>Email Address:</strong> {{$user->email}}</p>

            <br />
            <br />
            <h2>Pet Details</h2>

            <p style="font-size:17px;"><strong>Chip Number:</strong> {{$data->chip_no_string}}</p>
            <p style="font-size:17px;"><strong>Name:</strong> {{$data->name}}</p>
            <p style="font-size:17px;"><strong>Breed:</strong> {{$data->breed}}</p>
            <p style="font-size:17px;"><strong>Colour:</strong> {{$data->colour}}</p>
            <p style="font-size:17px;"><strong>Sex:</strong> {{$data->sex}}</p>
            <p style="font-size:17px;"><strong>Pet Type:</strong> {{$data->pet_type}}</p>
            <p style="font-size:17px;"><strong>Medical Info:</strong> {{$data->medical_info}}</p>


        </div>