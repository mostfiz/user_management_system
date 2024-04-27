<?php 

    require_once __DIR__ . '/../Services/PaginationService.php'; 
    require_once __DIR__ . '/../Services/UserListingService.php';
    use PHPUnit\Framework\TestCase;

    class UserListingServiceTest extends TestCase {
        private $mockDb;
        private $paginationServiceMock;
        private $userListingService;
    
        protected function setUp(): void {
            // Mock the PaginationService and PDO objects
            $this->mockDb = $this->createMock(PDO::class);
            $this->paginationServiceMock = $this->createMock(PaginationService::class);
    
            // Instantiate the UserListingService with mocked dependencies
            $this->userListingService = new UserListingService($this->mockDb);
            $this->userListingService->setPaginationService($this->paginationServiceMock);
        }
    
        public function testDisplayUsers(): void {
            // Mock the paginateUsers method of PaginationService
            $this->paginationServiceMock->expects($this->once())
                                        ->method('paginateUsers')
                                        ->with(1, 10)
                                        ->willReturn(['success' => true, 'users' => [['id' => 1, 'username' => 'user1'], ['id' => 2, 'username' => 'user2']]]);
    
            // Perform the test
            $result = $this->userListingService->displayUsers(1, 10);
    
            // Assert the result
            $this->assertTrue($result['success']);
            $this->assertArrayHasKey('users', $result);
            $this->assertCount(2, $result['users']); // Assuming 2 users were fetched
        }
    
        public function testSearchUsers(): void {
            // Mock the prepare, bindValue, and execute methods of PDOStatement
            $stmtMock = $this->createMock(PDOStatement::class);
            $stmtMock->expects($this->once())
                     ->method('bindValue')
                     ->with(':keyword', '%keyword%', PDO::PARAM_STR);
            $stmtMock->expects($this->once())
                     ->method('execute')
                     ->willReturn(true);
            $stmtMock->expects($this->once())
                     ->method('fetchAll')
                     ->with(PDO::FETCH_ASSOC)
                     ->willReturn([['username' => 'user1', 'email' => 'user1@example.com'], ['username' => 'user2', 'email' => 'user2@example.com']]);
    
            // Mock the prepare method of PDO
            $this->mockDb->expects($this->once())
                         ->method('prepare')
                         ->with("SELECT username, email FROM users WHERE username LIKE :keyword OR email LIKE :keyword")
                         ->willReturn($stmtMock);
    
            // Perform the test
            $result = $this->userListingService->searchUsers('keyword');
    
            // Assert the result
            $this->assertTrue($result['success']);
            $this->assertArrayHasKey('users', $result);
            $this->assertCount(2, $result['users']); // Assuming 2 users were fetched
        }
    }
    
?>