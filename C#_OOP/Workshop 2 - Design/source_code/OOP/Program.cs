using Workshop_2.Controller;
using Workshop_2.View;

namespace Workshop_2
{
    class Program
    {
        static void Main(string[] args)
        {
            // Creating new instances of view, controller and model
            //var memberDAL = new MemberDAL();
            var AppView = new AppView();
            var BoatView = new BoatView();
            var MemberView = new MemberView();
            var MenuView = new MenuView();
            var appController = new AppController(AppView, BoatView, MemberView, MenuView);

            // Launching controller method. 
            appController.doControll();

        }
    }
}