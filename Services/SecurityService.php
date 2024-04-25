<?php 
    class SecurityService{
        public function hashPassword($password) {
            // Hash the password before storing it in the database
            return password_hash($password, PASSWORD_BCRYPT);
        }
        
        public function preventXSS($input) {
            // Remove any potential JavaScript event handlers
            $sanitizedInput = preg_replace('/<([a-z][a-z0-9]*)[^>]*?(on\w*)\s*=\s*([^\s>]+)([^>]*)>/i', '<$1$4>', $input);

            // Convert all characters to HTML entities
            $sanitizedInput = htmlentities($sanitizedInput, ENT_QUOTES, 'UTF-8');

            // Decode certain HTML entities back to their original characters
            $sanitizedInput = str_replace(
                array('&amp;#', '&amp;quot;', '&amp;lt;', '&amp;gt;', '&amp;amp;'),
                array('&#', '&quot;', '&lt;', '&gt;', '&amp;'),
                $sanitizedInput
            );

            // Return the sanitized input
            return $sanitizedInput;
        }
    }
?>