<?php

namespace app\action;

use app\models\UserQuery;
use app\repository\UserRepositoryInterface;
use app\session\SessionInterface;
use app\validator\ValidatorFactoryInterface;
use app\view\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Main page
 */
class IndexAction implements ActionInterface
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var ValidatorFactoryInterface
     */
    protected $validatorFactory;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @param ViewInterface $view
     * @param ValidatorFactoryInterface $validatorFactory
     * @param SessionInterface $session
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        ViewInterface $view,
        ValidatorFactoryInterface $validatorFactory,
        SessionInterface $session,
        UserRepositoryInterface $userRepository
    ) {
        $this->view = $view;
        $this->validatorFactory = $validatorFactory;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * Run the action
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        $userId = $this->session->get('userId');
        $formData = $request->getParsedBody();
        $searchData = [];
        $errors = [];

        if ('POST' === $request->getMethod()) {
            $validator = $this->validatorFactory->createInstance($formData);

            $validator->required(['email', 'password']);
            $validator->email('email');
            $validator->lengthMax('email', 100);
            $validator->lengthMin('password', 6);
            $validator->regexp('password', '/\d/i');

            if ($validator->validate()) {
                $model = $this->userRepository->findByEmail($formData['email']);

                if ($model && password_verify($formData['password'], $model->getPassword())) {
                    $this->session->set('userId', $model->getId());
                    return $response->withHeader('Location', '/');
                } else {
                    $errors['email'] = ['Wrong email or password'];
                }
            } else {
                $errors = $validator->getErrors();
            }
        }

        $response->getBody()->write($this->view->render($userId ? 'account' : 'index', [
            'formData' => $formData,
            'searchData' => $searchData,
            'errors' => $errors,
            'userId' => $userId
        ]));
        return $response;
    }
}
