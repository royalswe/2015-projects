using NumberGuessingGame.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace NumberGuessingGame.Controllers
{
    public class GuessNumberController : Controller
    {/// <summary>
    /// Reusing code from Webforms lab 1.4
    /// </summary>
        private SecretNumber secretNumber
        {
            get
            {
                var number = Session["number"] as SecretNumber;
                //Session.Timeout = 1;
                if (number == null)
                {
                    return secretNumber = new SecretNumber();
                }
                else
                {
                    return number;
                }
            }

            set
            {
                Session["number"] = value;
            }
        }

        // GET: GuessNumber
        public ActionResult Index()
        {
            Session.Clear();
            return View();
        }

        // POST
        [HttpPost, ActionName("Index")]
        [ValidateAntiForgeryToken]
        public ActionResult Index([Bind(Include = "NewNumber")]GuessViewModel model) 
        {
            if (Session.IsNewSession)
            {
                return View("SessionError");
            }
           
            if (ModelState.IsValid)
            {
                var guessViewModel = new GuessViewModel { secretNumber = secretNumber };

                var outcomes = secretNumber.MakeGuess(model.NewNumber);

                if (outcomes == Outcome.Right || outcomes == Outcome.NoMoreGuesses)
                {
                    return View("GameOver", guessViewModel);
                }

                return View("Guesses", guessViewModel);
            }

            return View();
        }  
    }
}