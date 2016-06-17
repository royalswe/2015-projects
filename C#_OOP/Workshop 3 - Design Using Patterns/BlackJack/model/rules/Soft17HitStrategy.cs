using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class Soft17HitStrategy : IHitStrategy
    {
        // Soft 17 means that the dealer has 17 but in a combination of Ace and 6 (for example Ess, tvåa, tvåa, tvåa). 
        // This means that the Dealer can get another card valued at 10 but still have 17 as the value of the ace is reduced to 1.

        private const int g_hitLimit = 17;

        public bool DoHit(model.Player a_dealer)
        {
            var hand = a_dealer.GetHand();
            int score = a_dealer.CalcScore();

            // If the dealer has 17.
            if (score == g_hitLimit)
            {
                foreach (var card in hand)
                {                                       
                    // In a comibination of Ace and 6.
                    if (card.GetValue() == Card.Value.Ace && score - 11 == 6)
                    {
                        // The dealer does another hit.
                        return true;
                    }
                } 
            }

            return score < g_hitLimit;
        }
    }
}
