<?php

namespace Developer\ProductWarranty\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\State;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\User\Model\UserFactory;
use Magento\Webapi\Model\Authorization\TokenUserContext;

class MyEvent implements ObserverInterface
{
    const string filename = BP . '/var/log/warranty.json';
    private Session $session;
    private TokenUserContext $tokenUserContext;
    private State $appState;
    private UserFactory $userFactory;

    public function __construct(State $appState, Session $session, TokenUserContext $tokenUserContext, UserFactory $userFactory)
    {
        $this->checkIfFileExistsOrCreate();
        $this->appState = $appState;
        $this->session = $session;
        $this->tokenUserContext = $tokenUserContext;
        $this->userFactory = $userFactory;
    }

    public function checkIfFileExistsOrCreate(): void
    {
        if (!file_exists(self::filename)) {
            file_put_contents(self::filename, json_encode([]));
        }
    }

    public function execute(Observer $observer): void
    {
        $old = $observer->getData('old');
        $new = $observer->getData('new');
        $dateTime = $observer->getData('dateTime');

        $scope = $this->getScope();
        $entry = [
            'id' => $old['entity_id'],
            'old' => (integer) $old['warranty'],
            'new' => $new['warranty'],
            'date' => $dateTime,
            'scope' => $scope,
        ];
        $this->addAdminUser($entry, $scope);

        $currentData = json_decode(file_get_contents(self::filename), true);
        $currentData[] = $entry;

        file_put_contents(self::filename, json_encode($currentData, JSON_PRETTY_PRINT));
    }

    public function getScope(): string
    {
        try {
            $scope = $this->appState->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $scope = 'unknown';
        }
        return $scope;
    }

    public function addAdminUser(&$entry, $scope): void
    {
        if($scope == 'adminhtml') {
            $this->addAdminUserBySession($entry);
        } else if($scope == 'webapi_rest') {
            $this->addAdminUserByToken($entry);
        }
    }

    public function addAdminUserBySession(&$entry): void
    {
        $user = $this->session->getUser();
        if($user) {
            $entry['user'] = $user->getUsername();
        }
    }

    public function addAdminUserByToken(&$entry): void
    {
        $id = $this->tokenUserContext->getUserId();
        if($id) {
            $user = $this->userFactory->create()->load($id);
            $entry['user'] = $user->getUsername();
        }
    }
}
