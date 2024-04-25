<?php
    require_once __DIR__ . '/../Services/SecurityService.php'; 

    use PHPUnit\Framework\TestCase;

    class SecurityServiceTest extends TestCase {
        public function testPreventXSS(): void {
            // Arrange
            $securityService = new SecurityService();
    
            // Input containing potential XSS payload
            $input = '<script>alert("XSS attack!")</script>';
    
            // Expected sanitized output
            $expectedOutput = '&lt;script&gt;alert(&quot;XSS attack!&quot;)&lt;/script&gt;';
    
            // Act
            $sanitizedInput = $securityService->preventXSS($input);
    
            // Assert
            $this->assertEquals($expectedOutput, $sanitizedInput);
        }
    }
    
?>