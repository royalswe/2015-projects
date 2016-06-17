using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class AmericanNewGameStrategy : INewGameStrategy
    {
        public bool NewGame(Dealer a_dealer, Player a_player)
        {

            a_dealer.DealCard(true, a_player);

            a_dealer.DealCard(true, a_dealer);

            a_dealer.DealCard(true, a_player);

            a_dealer.DealCard(false, a_dealer);

            return true;
        }
    }
}
