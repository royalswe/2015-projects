using System;
using Workshop_2.Model;

namespace Workshop_2.View
{
    class MenuView
    {
        public void welcomeMessage()
        {
            Console.WriteLine(AppStrings.menuWelcome);
            Console.WriteLine();
        }
        public ListOption listMenu()
        {
            Console.WriteLine("0. {0}", AppStrings.menuMember);
            Console.WriteLine("1. {0}", AppStrings.menuAddNewMember);
            Console.WriteLine("2. {0}", AppStrings.menuAddNewBoat);
            Console.WriteLine("3. {0}", AppStrings.menuRenderCompactListOfMembers);
            Console.WriteLine("4. {0}", AppStrings.menuRenderVerboseListOfMembers);
            Console.WriteLine("5. {0}", AppStrings.editMember);
            Console.WriteLine("6. {0}", AppStrings.editBoat);
            Console.WriteLine("7. {0}", AppStrings.removeMember);
            Console.WriteLine("8. {0}", AppStrings.removeBoat);
            Console.WriteLine("Q. {0}", AppStrings.menuQuit);
            Console.Write(AppStrings.menuMakeChoice);

            while (true)
            {
                string keyValue = Console.ReadLine();
                switch (keyValue.ToLower())
                {
                    case "0":
                        return ListOption.viewMember;
                    case "1":
                        return ListOption.addMember;
                    case "2":
                        return ListOption.addBoat;
                    case "3":
                        return ListOption.showCompactListOfMembers;
                    case "4":
                        return ListOption.showVerboseListOfMembers;
                    case "5":
                        return ListOption.editMember;
                    case "6":
                        return ListOption.editBoat;
                    case "7":
                        return ListOption.removeMember;
                    case "8":
                        return ListOption.removeBoat;
                    case "q":
                        return ListOption.quit;
                    default:
                        Console.Write(AppStrings.failMenuWrongChoice);
                        break;
                }
            }
        }
    }
}
