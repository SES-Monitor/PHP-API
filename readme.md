
# SES Monitor PHP API
Interact with the [SES Monitor](https://www.sesmonitor.com) API.

## Authentication
You'll need to create an API token within your SES Monitor account and pass this as the only parameter when instantiating the API client.
```
$smClient = new SMClient('YOUR_API_KEY');
```

## Fetch domains
You can fetch domains using the "listDomains" method. This method accepts three parameters: page, per_page and query params. [Domains API Documentation](https://www.sesmonitor.com/articles/ses-monitor-domains-api)
````
// List domain names, page 1, 25 per page, no query
$domains = $smClient->listDomains(1, 25, []);
````
You can also fetch a single domain by either the "uuid" or "domain" query parameter using the "getDomain" method.
````
// Get single domain
$domains = $smClient->getDomain([
    "domain" => "sesmonitor.com"
]);
````

## Fetch messages
You can fetch messages using the "listMessages" method. This method accepts three parameters: page, per_page and query params. [Messages API Documentation](https://www.sesmonitor.com/articles/ses-monitor-messages-api)
````
// List messages, page 1, 25 per page, no query
$messages = $smClient->listMessages(1, 25, []);
````
You can also fetch a single message by specifying the "uuid" query parameter using the "getMessage" method.
````
// Get single message
$message = $smClient->getMessage([
    "uuid" => "f4f4ed2e-8fd5-11eb-a84a-2ac2596b13f2"
]);
````

## Rate limiting
All API requests are rate-limited to 120 requests per 60 minutes using a "fixed-window" approach i.e. once used up you'll have to wait until the next 60 minte window to make more requests.