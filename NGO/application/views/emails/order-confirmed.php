<p><strong>Your order #{order_reference} has been confirmed. </strong></p>

<table border="1">
        <tr>
            <td width="50%">Item</td>
            <td width="15%">Price</td>
            <td width="15%">Quantity</td>
            <td width="20%">Subtotal</td>
        </tr>
        {modifier_data}
            {options}
        {/modifier_data}
</table>

<br>

<p><strong>Address</strong></p>
<table border="1">
    <tr>
        <td width="20%">Name</td>
        <td width="80%">{first_name} {last_name}</td>
    </tr>
    <tr>
        <td width="20%">Email</td>
        <td width="80%">{email}</td>
    </tr>
    <tr>
        <td width="20%">Phone</td>
        <td width="80%">{phone}</td>
    </tr>
    <tr>
        <td width="20%">City</td>
        <td width="80%">{city}</td>
    </tr>
    <tr>
        <td width="20%">Zipcode</td>
        <td width="80%">{zipcode}</td>
    </tr>
    <tr>
        <td width="20%">Address 1</td>
        <td width="80%">{address_line_1}</td>
    </tr>
    <tr>
        <td width="20%">Address 2</td>
        <td width="80%">{address_line_2}</td>
    </tr>
</table>

<br>

<p><strong>Payment information</strong></p>
<table border="1">
    <tr>
        <td width="20%">Payment via</td>
        <td width="80%">{payment_mode}</td>
    </tr>
    <tr>
        <td width="20%">Checkout</td>
        <td width="80%">{checkout_type}</td>
    </tr>
    <tr>
        <td width="20%">Sub total</td>
        <td width="80%">{subtotal}</td>
    </tr>
    <tr>
        <td width="20%">Tax amount</td>
        <td width="80%">{tax_amount}</td>
    </tr>
    <tr>
        <td width="20%">Grand total</td>
        <td width="80%">{payed_amount}</td>
    </tr>
    <tr>
        <td width="20%">Delivery charge</td>
        <td width="80%">{delivery_charge}</td>
    </tr>
</table>

<br>