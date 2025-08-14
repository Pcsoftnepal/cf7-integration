# Shortcode Reference

This document describes all the shortcodes available in the Contact Form 7 to HubSpot Integration plugin.

## HubSpot Mapping Shortcode

### Syntax
```
[hubspot-mapping property="property-name" field="field-name" type="type"]
```

### Parameters

| Parameter | Required | Description | Default |
|-----------|----------|-------------|---------|
| `property` | Yes | The HubSpot contact property to map to | N/A |
| `field` | Yes | The Contact Form 7 field name to map from | N/A |
| `type` | No | The mapping type (contact or deal) | contact |

### Examples

#### Basic Contact Property Mapping
```
[hubspot-mapping property="firstname" field="your-name"]
```

#### Email Mapping
```
[hubspot-mapping property="email" field="your-email"]
```

#### Custom Property Mapping
```
[hubspot-mapping property="company" field="your-company"]
```

#### Deal Property Mapping
```
[hubspot-mapping property="dealname" field="deal-name" type="deal"]
```

### Property Types

The plugin supports mapping to the following HubSpot contact properties:

- `firstname` - Contact's first name
- `lastname` - Contact's last name
- `email` - Contact's email address
- `phone` - Contact's phone number
- `company` - Contact's company
- `jobtitle` - Contact's job title
- `address` - Contact's address
- `city` - Contact's city
- `state` - Contact's state
- `zip` - Contact's ZIP code
- `country` - Contact's country

### Custom Properties

You can also map to custom HubSpot properties by specifying the property name in the `property` parameter.

### Usage Notes

1. Place the shortcode inside your Contact Form 7 form
2. Each shortcode maps one form field to one HubSpot property
3. Multiple shortcodes can be used in a single form
4. The `field` parameter should match the name of the corresponding Contact Form 7 field
5. The `property` parameter should match the HubSpot property name