<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(ProductRepository $repo, CartService $cs): Response
    {
        $cartWithData = $cs->cartWithData();
        $total = $cs->total();
        // $session = $rs->getSession();
        // $cart = $session->get('cart', []);

        // //je vais créer un nouveau tableau qui contiendra des objets Product et les quantité de chaque objet
        // $cartWithData = [];
        // $total = 0;

        // //Pour chaque $id qui se trouve dans le tableau $cart, j'ajoute une case au tableau $cartWithData
        // //dans chacune de ces il y aura mon tableau associatif contenant 2 case: une pour product et une pour quantity
        // foreach($cart as $id => $quantity)
        // {

        //     $produit = $repo->find($id);
        //     $cartWithData[]= [
        //         'product' => $produit,
        //         'quantity' => $quantity
        //     ];
        //     $total += $produit->getPrice() * $quantity;
        // }

        return $this->render('cart/index.html.twig',[
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add($id, CartService $cs)
    {
        
        $cs->add($id);
        return $this->redirectToRoute('app_product');
    }

    
    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs)
    {
        
        $cs->remove($id);
        
        return $this->redirectToRoute('app_cart');
    }
}
