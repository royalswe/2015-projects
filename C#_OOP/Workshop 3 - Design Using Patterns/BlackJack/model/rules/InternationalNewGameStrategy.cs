using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class InternationalNewGameStrategy : INewGameStrategy
    {

        public bool NewGame(Dealer a_dealer, Player a_player)
        {
            var testSoft17Strategy = false; //Change this to "true" to test Soft17HitStrategy

            if (testSoft17Strategy)
            {
                Card card1 = new Card(Card.Color.Clubs, Card.Value.Three);
                Card card2 = new Card(Card.Color.Hearts, Card.Value.Three);
                Card card3 = new Card(Card.Color.Hearts, Card.Value.Ace);
                card1.Show(true);
                card2.Show(true);
                card3.Show(true);
                a_dealer.DealCard(card1);
                a_dealer.DealCard(card2);
                a_dealer.DealCard(card3);
            }
            else
            {
                a_dealer.DealCard(true, a_player);
                a_dealer.DealCard(true, a_dealer);
                a_dealer.DealCard(true, a_player);
            }

            return true;
        }
    }
}
