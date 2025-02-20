<?php

namespace App\Controllers;

class Cards extends BaseController
{
       
    public function distribute_cards() {
        $num_players = $this->request->getPost('num_players');

        if ($num_players <= 0 || $num_players > 52) {
            echo json_encode(["error" => "Input value does not exist or value is invalid"]);
            return;
        }

        $deck = $this->create_deck();

        shuffle($deck);

        $cards_per_player = floor(52 / $num_players);
        $distributed_cards = $this->distribute($deck, $num_players, $cards_per_player);

        return json_encode($distributed_cards);
    }

    private function create_deck() {
        $suits = ['S', 'H', 'D', 'C']; 
        $values = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 'X', 'J', 'Q', 'K'];

        $deck = [];
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = $suit . '-' . $value;
            }
        }

        return $deck;
    }

    private function distribute($deck, $num_players, $cards_per_player) {
        $players = [];
        $counter = 0;

        foreach ($deck as $card) {
            $players[$counter % $num_players][] = $card;
            $counter++;
        }

        $formatted_players_cards = [];
        for ($i = 0; $i < $num_players; $i++) {
            $formatted_players_cards[] = implode(',', $players[$i]);
        }

        return $formatted_players_cards;
    }
}
