<?php

namespace app\action;

use app\country\CountryListInterface;
use app\model\UserFactoryInterface;
use app\repository\UserRepositoryInterface;
use app\session\SessionInterface;
use app\validator\ValidatorFactoryInterface;
use app\view\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Signup page
 */
class SignupAction implements ActionInterface
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var CountryListInterface
     */
    protected $countryList;

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
     * @var UserFactoryInterface
     */
    protected $userFactory;

    /**
     * @param ViewInterface $view
     * @param CountryListInterface $countryList
     * @param ValidatorFactoryInterface $validatorFactory
     * @param SessionInterface $session
     * @param UserRepositoryInterface $userRepository
     * @param UserFactoryInterface $userFactory
     */
    public function __construct(
        ViewInterface $view,
        CountryListInterface $countryList,
        ValidatorFactoryInterface $validatorFactory,
        SessionInterface $session,
        UserRepositoryInterface $userRepository,
        UserFactoryInterface $userFactory
    ) {
        $this->view = $view;
        $this->countryList = $countryList;
        $this->validatorFactory = $validatorFactory;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    /**
     * Run the action
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        $formData = $request->getParsedBody();
        $countryList = $this->countryList->getList();
        $errors = [];

        if ('POST' === $request->getMethod()) {
            $validator = $this->validatorFactory->createInstance($formData);

            $validator->required(['name', 'email', 'password', 'country']);
            $validator->lengthBetween('name', 3, 20);
            $validator->email('email');
            $validator->lengthMax('email', 100);
            $validator->lengthMin('password', 6);
            $validator->regexp('password', '/\d/i');
            $validator->inKeys('country', $countryList);

            if ($validator->validate()) {
                if ($this->userRepository->findByEmail($formData['email'])) {
                    $errors['email'] = ['This email already exists'];
                } else {
                    $model = $this->userFactory->createInstance();

                    $model->setName($formData['name']);
                    $model->setEmail($formData['email']);
                    $model->setPassword(password_hash($formData['password'], PASSWORD_BCRYPT));
                    $model->setCountry($formData['country']);
                    $model->setTimezone(isset($formData['timezone']) ? $formData['timezone'] : '');
                    $model->setCreated(date('Y-m-d H:i:s'));

                    $this->userRepository->save($model);
                    $this->session->set('userId', $model->getId());

                    return $response->withHeader('Location', '/');
                }
            } else {
                $errors = $validator->getErrors();
            }
        }

        $response->getBody()->write($this->view->render('signup', [
            'formData' => $formData,
            'countryList' => $countryList,
            'errors' => $errors
        ]));
        return $response;
    }
}
