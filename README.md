#Installation#

1. Simply clone or download the `GuzzleWalmart.php` class into your project. Location isn't really important, however you'll want to correct the namespace in the class to jive with your architecture.
2. Apply for a Walmart Open API key at https://developer.walmartlabs.com/

#Configuration#

##Set up a parameter for your API Key##

Add the following to your `parameters.yml` file and don't forget to do the same to your `.dist` file

    // parameters.yml
    walmart_api_key: XXXXXXXXXXXXXXXXXXXXXXX

##Register the Class as a Service##

To make this more portable and service oriented, register the class as a service and inject the API key dependency

    // services.yml
    services:
      guzzle_walmart:
        class: MyBundle\GuzzleWalmart
        arguments: [%walmart_api_key%]

#Usage#

Example usage from a controller

    <?php
    namespace MyBundle\Controller;
    
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    
    class ProductsController extends Controller
    {
        public function defaultAction()
        {
            $upcCodes = array("072959015084","072959014087"); // or populate this from your product entities
            
            $guzzleWalmart = $this->get("guzzle_walmart"); // new instance
            
            $walmartProducts = $guzzleWalmart->getProducts($upcCodes); // method call
    
            return $this->render('MyBundle::products.html.twig', array(
              'walmartProducts' => $products
            ));
        }
    }
    
