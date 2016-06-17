﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class RulesFactory
    {
        public IHitStrategy GetHitRule()
        {
            var basicHitStrategy = false;
            if (basicHitStrategy)
                return new BasicHitStrategy();
            else
                return new Soft17HitStrategy();
        }

        public INewGameStrategy GetNewGameRule()
        {
            var internationalNewGameStrategy = true;
            if (internationalNewGameStrategy)
                return new InternationalNewGameStrategy();
            else
                return new AmericanNewGameStrategy();
        }

        public IWinner GetWinnerRule()
        {
            var winnerOriginal = true;
            if (winnerOriginal)
                return new WinnerOriginal();
            else
                return new WinnerProPlayer();
        }
    }
}
