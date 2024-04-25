<?php
    require_once __DIR__ . '/../Services/PaginationService.php'; 

    use PHPUnit\Framework\TestCase;
    
    class PaginationServiceTest extends TestCase {
        private $mockDb;
        private $paginationService;
    
        protected function setUp(): void {
            parent::setUp();
            // Create a mock database connection
            $this->mockDb = $this->createMock(PDO::class);
            // Create an instance of PaginationService with the mock database connection
            $this->paginationService = new PaginationService($this->mockDb);
        }
    
        public function testPaginateUsers(): void {
            // Mocking the prepare, bindParam, and execute methods of PDOStatement
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                     ->method('bindParam')
                     ->withConsecutive([1, 0, PDO::PARAM_INT], [2, 10, PDO::PARAM_INT]);
            $stmtMock->expects($this->once())
                     ->method('execute')
                     ->willReturn(true);
            $stmtMock->expects($this->once())
                     ->method('fetchAll')
                     ->with(PDO::FETCH_ASSOC)
                     ->willReturn([['id' => 1, 'username' => 'user1'], ['id' => 2, 'username' => 'user2']]); // Sample user data
        
            // Mocking the prepare method of PDO
            $this->mockDb->expects($this->once())
                         ->method('prepare')
                         ->with("SELECT * FROM users LIMIT ?, ?")
                         ->willReturn($stmtMock);
        
            // Perform the test
            $result = $this->paginationService->paginateUsers(1, 10); // Assuming $page=1, $perPage=10
        
            // Assert the result
            $this->assertTrue($result['success']);
            $this->assertArrayHasKey('users', $result);
            $this->assertCount(2, $result['users']); // Assuming 2 users were fetched
        }
        
        
    }
    
?>