<?php

namespace Drupal\dojo_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
//parameters
use Drupal\user\UserInterface;
//links
use Drupal\Core\Link;
use Drupal\Core\Url;



class DojoPagesController extends  ControllerBase
{

  //inicio inyección de servicios
  protected $currentUser;

  public function __construct(AccountInterface $current_user)
  {
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('current_user')
    );
  }
// fin inyección de servicios

  public function simple(){
    return [
      'markup' => $this->t('This is a simple page')
    ];
  }

  public function calculator($num1, $num2){
    // a) Check that the values provided are numbers
    // and if not, launch to exception
    if (!is_numeric($num1) || !is_numeric($num2)){
      throw new BadRequestHttpException(t('No numeric arguments specified.'));
    }

    //b) the results is show in list format html
    // each element of list add to array

    $list[] = $this->t("@num1 + @num2 = @sum",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@sum' => $num1 + $num2
      ]);

    $list[] = $this->t("@num1 - @num2 = @difference",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@difference' => $num1 - $num2
      ]);

    $list[] = $this->t("@num1 x @num2 = @product",
      [
        '@num1' => $num1,
        '@num2' => $num2,
        '@product' => $num1 * $num2
      ]);
    //avoid division error for zero
    if ($num2 != 0){
      $list[] = $this->t("@num1 / @num2 = @division",
        [
        '@num1' => $num1,
        '@num2' => $num2,
        '@division' => $num1 / $num2
        ]);
    }
    else {
      $list[] = $this->t("@num1 / @num2 = undefined (division by zero)",
        [
          '@num1' => $num1,
          '@num2' => $num2
        ]);
    }
    // d) the list is transform in a array
    $output['dojo_pages_calculator'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Operations:'),
    ];
    return $output;
  }

  public function user(UserInterface $user){
    $list[] = $this->t("Username: @username", ['@username' => $user->getAccountName()]);
    $list[] = $this->t('Email: @email', ['@email' => $user->getEmail()]);
    $list[] = $this->t('Roles: @roles', ['@roles' => implode(', ', $user->getRoles())]);
    $list[] = $this->t("Last accessed time: @lastaccess", [
      '@lastaccess' => \Drupal::service('date.formatter')->format($user->getLastAccessedTime(), 'short')
    ]);

    $output['dojo_pages_user'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('User data:'),
    ];

    return $output;
  }

  public function links() {
    // link to /admin/structure/blocks
    $url1 = Url::fromRoute('block.admin_display');
    $link1 = Link::fromTextAndUrl('Go to the Block administration page', $url1);
    //url page to home
    $url3 = Url::fromRoute('<front>');
    $link3 = Link::fromTextAndUrl('Go to Front page', $url3);
    //link to /node/1
    $url4 = Url::fromRoute('entity.node.canonical', ['node' => 1]);
    $link4 = Link::fromTextAndUrl('Link to node/1', $url4);
    //link to form node
    $url5 = Url::fromRoute('entity.node.edit_form', ['node' => 1]);
    $link5 = Link::fromTextAndUrl('LInk to edit node/1', $url5);
    //link to external url
    $url6 = Url::fromUri('https://google.com');
    $link6 = Link::fromTextAndUrl('Link to google', $url6);
    //link to internal url
    $url7 = Url::fromUri('internal:/core/themes/bartik/css/layout.css');
    $link7 =Link::fromTextAndUrl('Link to internal url for example layout.css', $url7);
    //link external with attributes
    $url8 = Url::fromUri('https://www.google.com');
    $link_options = [
      'attributes' => [
        'class' => [
          'external-link',
          'list'
        ],
        'target' => '_blank',
        'title' => 'Go to google.com'
      ],
    ];
    $url8->setOptions($link_options);
    $link8 = Link::fromTextAndUrl('Link to Google.com', $url8);

    //link normal
    $list[] = $link1;
    //link que pasa a string
    $list[] = $this->t('This text contains a link to %enlace. Just convert it to String to use it into a text.', ['%enlace' => $link1->toString()]);
    $list[] = $link3;
    $list[] = $link4;
    $list[] = $link5;
    $list[] = $link6;
    $list[] = $link7;
    $list[] = $link8;

    $output['dojo_pages_links'] = [
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => 'Example of links:',
    ];

    return $output;
  }

  //adicion del servicio currentUser
  public function tab1() {
    $output = '<p>' . $this->t('This is the content of Tab 1') . '</p>';

    if ($this->currentUser->hasPermission('administer nodes')){
      $output .= '<p>' . $this->t('This extra text is only displayed if the current user can administer nodes.') . '</p>';
    }

    return ['#markup' => $output];
  }
  public function tab2() {
    return ['#markup' => '<p>' . $this->t('This is the content of Tab 2') . '</p>'];
  }
  public function tab3() {
    return ['#markup' => '<p>' . $this->t('This is the content of Tab 3') . '</p>'];
  }
  public function tab3a() {
    return ['#markup' => '<p>' . $this->t('This is the content of Tab 3a') . '</p>'];
  }
  public function tab3b() {
    return ['#markup' => '<p>' . $this->t('This is the content of Tab 3b') . '</p>'];
  }
  public function extratab() {
    return ['#markup' => '<p>' . $this->t('This is the content of Extratab') . '</p>'];
  }
  public function action1() {
    return ['#markup' => '<p>' . $this->t('This is the content of action1') . '</p>'];
  }
}


