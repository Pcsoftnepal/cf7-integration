# Quick Start Guide

This guide will help you get started with the Contact Form 7 to HubSpot Integration plugin quickly.

## Prerequisites

Before you begin, ensure you have:
- A working WordPress site with Contact Form 7 installed
- A HubSpot account with API access
- Administrative access to your WordPress site

## Step 1: Install the Plugin

1. Log into your WordPress dashboard
2. Navigate to **Plugins → Add New**
3. Search for "Contact Form 7 to HubSpot Integration"
4. Click **Install Now** and then **Activate**

## Step 2: Get Your HubSpot API Key

1. Log into your HubSpot account
2. Navigate to **Settings** → **Integrations** → **HubSpot API**
3. Generate a new API key
4. Copy the API key for later use

## Step 3: Configure the Plugin

1. In your WordPress dashboard, go to **Contact Form 7** → **Settings** → **HubSpot Integration**
2. Paste your HubSpot API key into the provided field
3. Save the settings

## Step 4: Create a Contact Form

1. Go to **Contact Forms** → **Add New**
2. Create a basic contact form with fields like Name, Email, etc.
3. Add the HubSpot mapping shortcodes to your form:

```
<label> Your Name *
    [text* your-name] 
</label>

<label> Your Email *
    [email* your-email] 
</label>

[hubspot-mapping property="firstname" field="your-name"]
[hubspot-mapping property="email" field="your-email"]
```

## Step 5: Test the Integration

1. Submit the form
2. Check your HubSpot account to verify that the contact was created
3. Review the plugin logs for any errors (if you encounter issues)

## Common Issues and Solutions

### Issue: Form submissions aren't syncing to HubSpot

**Solution:**
1. Check that your HubSpot API key is correctly entered
2. Verify that the form has the correct HubSpot mapping shortcodes
3. Check the plugin logs for error messages

### Issue: Invalid API key error

**Solution:**
1. Regenerate your HubSpot API key
2. Re-enter the key in the plugin settings
3. Save the settings

### Issue: Missing required fields

**Solution:**
1. Ensure that all required HubSpot properties are mapped
2. Check that the form fields are properly named
3. Validate that the field mappings are correct

## Need Help?

If you're still having trouble, check our [Technical Documentation](technical-details.md) or contact support.

## Support

For support, please contact the plugin author or submit an issue on the GitHub repository.