using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace NumberGuessingGame.Models
{
    public class SecretNumber
    {
        private List<GuessedNumber> _guessedNumbers; // innehåller godkända gissningar
        private GuessedNumber _lastGuessedNumber;  // innehåller den senaste gissningen
        private int? _number; // hemliga talet
        public const int MaxNumberOfGuesses = 7;

        public SecretNumber()
        {
            _guessedNumbers = new List<GuessedNumber>(MaxNumberOfGuesses);
            Initialize();
        }

        public bool CanMakeGuess
        {
            get
            {
                if (Count >= MaxNumberOfGuesses || LastGuessedNumber.Outcome == Outcome.Right)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }

        public int Count
        {
            get
            {
                return _guessedNumbers.Count;
            }
        }

        public IList<GuessedNumber> GuessedNumbers
        {
            get { return _guessedNumbers.AsReadOnly(); }
        }

        public GuessedNumber LastGuessedNumber
        {
            get { return _lastGuessedNumber; }
        }

        public int? Number
        {
            get
            {
                if (CanMakeGuess)
                {
                    return null;
                }
                else
                {
                    return _number;
                }
            }

            private set
            {
                _number = value;
            }
        }

        public void Initialize()
        {
            _guessedNumbers.Clear();
            _lastGuessedNumber.Number = null;
            _number = new Random().Next(1, 101);
            _lastGuessedNumber.Outcome = Outcome.Indefinite;
        }

        public Outcome MakeGuess(int guess)
        {
            if(guess < 1 || guess > 100)
            {
                throw new ArgumentOutOfRangeException("Inte mellan 1 och 100");
            }

            _lastGuessedNumber.Number = guess;

            if (CanMakeGuess) { 

                if (_guessedNumbers.Exists(element => element.Number == guess))
                {
                    return _lastGuessedNumber.Outcome = Outcome.OldGuess;
                }
                else if (guess < _number)
                {
                    _lastGuessedNumber.Outcome = Outcome.Low;
                }
                else if (guess > _number)
                {
                    _lastGuessedNumber.Outcome = Outcome.High;
                }
                else if (guess == _number)
                {
                    _lastGuessedNumber.Outcome = Outcome.Right;
                }

                _guessedNumbers.Add(_lastGuessedNumber);

                if (Count >= MaxNumberOfGuesses)
                {
                    _lastGuessedNumber.Outcome = Outcome.NoMoreGuesses;
                }
            }

            return _lastGuessedNumber.Outcome;

        }

    }
}