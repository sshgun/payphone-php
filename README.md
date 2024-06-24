Simple PayPhone SDK
===================

Simple SDK to use the Payphone developer API, using PHP.

```
I'm in no way affiliated with, maintained, authorized, sponsored, or
officially associated with PayPhone, PayPhone.app  or any of its subsidiaries
or affiliates. The official PayPhone website can be found at https://paypohne.app
```

## PayPhone Button Box

 The payphone payment button box is a HTML form rendered by the official payphone
API. This lib only implements a simple interface to use the code from PHP. The
complete docs can be found [here](https://docs.payphone.app/en/doc/cajita-de-pagos-payphone/)

With this library first to all you need to render the payphone box. I going to
use plain PHP for this example.

```php
<?php

use sshgun\PayphonePHP\PayButtonBox;

require 'vendor/autoload.php';

# Your Application token must be defined here
const PAYPHONE_TOKEN = "";

$id = bin2hex(random_bytes(5));

# here We use a fake transaction of 1$. the 100 is because the API amount must
# be multiplied by 100. on the process
$box = new PayButtonBox(PAYPHONE_TOKEN, $id, 100);

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Include the box CSS-->
    <link rel="stylesheet" href="<?= $box->cssAsset() ?>">
</head>

<body>
    <!-- Include the official API box js -->
    <script type="module" src="<?= $box->jsAsset() ?>"></script>

    <!-- render the box with js, this use a DOMContentLoaded to render the box -->
    <?= $box->renderLoadJS() ?>
</body>

</html>
```

After that Payphone will make a request to the configured response URL. You
can handle this request with this library like:

```php
<?php

use sshgun\PayphonePHP\PayphoneClient;

require "vendor/autoload.php";

# your app token here
const TEST_TOKEN = "";

# we create a payphone client that will make the http request to the server

$client = new PayphoneClient(TEST_TOKEN);

$id = $_GET['id'];
$clientId = $_GET['clientTransactionId'];

# You should validate $id and $clientId before use it on the request.
# please filter the inputs. ;)

$data = $client->postPaymentConfirmation($id, $clientId);
if (is_null($data)) {
    # something wrong happened you can get the error with the getError method
    $err = $client->getError();
    die();

}

# If everything was ok $data must containt the returned data for the Payphone
# transaction.

var_dump($data);

```

## Payment link

Payphone offer a redirection model in which we can create a link that the user
must follow to make the payment. this behavior use redirections from your site
to the payphone domain and the the payphone server redirect the user back using
a response o cancel url.

To create the payment using this lib you only need to create a arguments object
and redirect the users to the url returned by the prepare endpoint.

```php
<?php

const PAYPHONE_TOKEN="YOUR app private token";

$args = new PreparedPaymentArgs;
$args->amount = 100; # 1$
$args->amountWithoutTax = 100; 
$args->responseUrl = "https://your-comback-url";
$args->cancellationUrl = "https://your-cancel-comback-url";
# the clientTransactionId is your internal identificator, can be the id of your
# orders or transaction table.
$args->clientTransactionId = "your-internal-id";

$client = new PayphoneClient(PAYPHONE_TOKEN); 

$data = $client->postCreatePaymentLinks($args);
if(is_null($data)){
    # an error ocurred. you can get the information on 
    $err = $client->getError();
    # show some information to the user.
    die();
}
# the operation was ok son wee need to redirect the user to the returned url
# here we only show the links.
?>

<a href="<?= $data->payWithCard =>">Pagar con Tarjeta</a>
<a href="<?= $data->payWithPayPhone =>">Pagar con Payphone</a>

```
