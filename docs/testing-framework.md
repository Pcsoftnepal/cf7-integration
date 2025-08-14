# Testing Framework for CF7 Integration Addons

## Overview

This document describes the testing framework for CF7 Integration plugin addons, including the ActiveCampaign addon that has been implemented.

## Testing Philosophy

The testing framework follows these principles:
1. **Comprehensive Coverage**: Every major component should have unit tests
2. **Realistic Scenarios**: Tests should cover realistic usage scenarios
3. **Easy Maintenance**: Tests should be easy to understand and update
4. **Clear Reporting**: Test results should be clear and actionable

## Test Structure

### Unit Tests
Located in `addons/[addon-name]/tests/` directory:
- Each addon has its own test suite
- Tests are organized by functionality
- Each test file corresponds to a specific class or function

### Test Categories
1. **Component Tests** - Test individual components (classes, functions)
2. **Integration Tests** - Test interactions between components
3. **Functional Tests** - Test end-to-end functionality

## Running Tests

### Prerequisites
- PHPUnit installed
- WordPress and CF7 Integration plugin installed
- Test database configured

### Running Specific Tests
To run tests for the ActiveCampaign addon:
```bash
cd /path/to/wp-content/plugins/cf7-integration
phpunit addons/activecampaign/tests/test-activecampaign-addon.php
```

### Running All Tests
To run all addon tests:
```bash
cd /path/to/wp-content/plugins/cf7-integration
phpunit addons/*/tests/
```

## Writing New Tests

### Test File Template
```php
<?php
/**
 * Test [Addon Name] addon functionality
 */
class Test_[Addon_Name]_Addon extends WP_UnitTestCase {
    
    public function setUp() {
        parent::setUp();
        // Setup test data
    }
    
    /**
     * Test [specific functionality]
     * 
     * @covers [ClassName]::[methodName]
     */
    public function test_[functionality]() {
        // Test implementation
    }
}
```

### Best Practices
1. **Descriptive Names**: Use descriptive test method names
2. **Single Assertion**: Each test should focus on a single behavior
3. **Test Isolation**: Tests should be independent of each other
4. **Clear Assertions**: Use clear, understandable assertions
5. **Mocking**: Use mocking for external dependencies when appropriate

## ActiveCampaign Addon Tests

The ActiveCampaign addon includes the following test coverage:
- Form data mapping
- API client initialization
- Field mapping functionality
- Addon instantiation

## Continuous Integration

The testing framework is designed to work with CI systems:
- Tests can be run automatically on code changes
- Test results can be published for review
- Failing tests are clearly reported

## Future Enhancements

1. **Integration Tests**: Add tests for actual API interactions
2. **Performance Tests**: Measure performance of key operations
3. **Security Tests**: Validate security measures
4. **Compatibility Tests**: Test with different WordPress versions