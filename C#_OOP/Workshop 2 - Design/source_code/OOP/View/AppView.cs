using System;
using Workshop_2.Model;

namespace Workshop_2.View
{
    class AppView
    {
        public void fail()
        {
            Console.WriteLine(AppStrings.failGeneral);
        }
        public void exit()
        {
            Console.Write(AppStrings.menuGoodBye);
            Console.ReadKey();
        }
        public void waitForUserToRead()
        {
            Console.WriteLine(AppStrings.pressAnyKey);
            Console.ReadLine();
        }

        public void renderCompactListElement(Member member, int numberOfBoats)
        {
            Console.WriteLine(AppStrings.renderCompactList, member.Name, member.MemberID, numberOfBoats);
        }

        public void renderListTitle(string title)
        {
            Console.WriteLine(title);
            Console.WriteLine(AppStrings.divider);
        }

        public void renderDivider()
        {
            Console.WriteLine(AppStrings.divider);
        }

        public void renderVerboseListElement(Member member)
        {
            Console.WriteLine(AppStrings.renderVerboseList, member.Name, member.SocialSecurityNumber, member.MemberID);
        }

        public void consoleClear()
        {
            Console.Clear();
        }

        public void renderNoMembers()
        {
            Console.WriteLine(AppStrings.renderNoMembers);
        }
    }
}
