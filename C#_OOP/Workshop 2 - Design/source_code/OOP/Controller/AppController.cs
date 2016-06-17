using System;
using System.Collections.Generic;
using Workshop_2.Model;
using Workshop_2.View;

namespace Workshop_2.Controller
{
    class AppController
    {
        #region View
        private AppView AppView;
        private BoatView BoatView;
        private MemberView MemberView;
        private MenuView MenuView;
        #endregion
        #region Model
        private MemberDAL MemberDAL;
        private BoatDAL BoatDAL;
        #endregion
        public AppController(AppView AppView, BoatView BoatView, MemberView MemberView, MenuView MenuView)
        {
            this.AppView = AppView;
            this.BoatView = BoatView;
            this.MemberView = MemberView;
            this.MenuView = MenuView;
            MemberDAL = new MemberDAL();
            BoatDAL = new BoatDAL();
        }
        public void doControll()
        {
            Dictionary<ListOption, Action> Menu = new Dictionary<ListOption, Action>();
            ListOption menuChoice = new ListOption();
            Menu.Add(ListOption.viewMember, doViewMember);
            Menu.Add(ListOption.addMember, doAddMember);
            Menu.Add(ListOption.addBoat, doAddBoat);
            Menu.Add(ListOption.showCompactListOfMembers, doRenderCompactListOfMembers);
            Menu.Add(ListOption.showVerboseListOfMembers, doRenderVerboseListOfMembers);
            Menu.Add(ListOption.editMember, doEditMember);
            Menu.Add(ListOption.editBoat, doEditBoat);
            Menu.Add(ListOption.removeMember, doRemoveMember);
            Menu.Add(ListOption.removeBoat, doRemoveBoat);
            Menu.Add(ListOption.quit, AppView.exit);

            while (menuChoice != ListOption.quit)
            {
                AppView.consoleClear();
                MenuView.welcomeMessage();
                menuChoice = MenuView.listMenu();
                AppView.consoleClear();
                Menu[menuChoice]();
            }
        }
        private void doViewMember()
        {
            if(MemberDAL.getMembers().Count != 0)
            {
                Member member = MemberView.getMemberByID();
                MemberView.renderMemberByID(member);
                BoatView.renderShortInformationAboutBoatsByMember(member);
            }
            else
            {
                AppView.renderNoMembers();
            }
            AppView.waitForUserToRead();
        }
        private void doAddMember()
        {
            var newMember = MemberView.addMember();
            
            if (MemberDAL.saveMember(newMember))
            {
                MemberView.renderAddMemberSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doAddBoat()
        {
            BoatView.addBoat();
            var member = MemberView.getMemberByID();
            MemberView.renderMemberByID(member);
            BoatView.renderShortInformationAboutBoatsByMember(member);
            var newBoat = BoatView.getNewBoat();
            if (BoatDAL.add(member, newBoat))
            {
                BoatView.renderAddBoatSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doEditMember()
        {
            Member member = MemberView.getMemberByID();
            MemberView.renderMemberByID(member);
            var newMember = MemberView.getMemberInfo(member.MemberID);
            if (MemberDAL.saveMember(newMember))
            {
                MemberView.renderEditMemberSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doEditBoat()
        {
            var member = MemberView.getMemberByID();
            var boats = new List<Boat>();

            MemberView.renderMemberByID(member);

            boats = BoatView.getBoatsByMember(member);
            int chooseBoat = BoatView.getBoatToEdit(boats);

            if (chooseBoat == -1)
            {
                // Do nothing, -1 indicates that there is no boats
            }
            else if (BoatDAL.updateBoat(member, chooseBoat, BoatView.getNewBoat()))
            {
                BoatView.renderEditBoatSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doRemoveMember()
        {
            var member = MemberView.getMemberByID();
            MemberView.renderMemberByID(member);
            if (MemberDAL.removeMember(member.MemberID))
            {
                MemberView.renderRemoveMemberSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doRemoveBoat()
        {
            var member = MemberView.getMemberByID();
            var boats = new List<Boat>();

            MemberView.renderMemberByID(member);

            boats = BoatView.getBoatsByMember(member);
            int chooseBoat = BoatView.getBoatToRemove(boats);

            if (chooseBoat == -1)
            {
                // Do nothing, -1 indicates that there is no boats
            }
            else if (BoatDAL.removeBoat(member, chooseBoat))
            {
                BoatView.renderRemoveBoatSuccess();
            }
            else
                AppView.fail();

            AppView.waitForUserToRead();
        }
        private void doRenderCompactListOfMembers()
        {
            AppView.renderListTitle(AppStrings.compactListOfMembers);
            var members = MemberDAL.getMembers();

            foreach (var member in members)
            {
                var numberOfBoats = member.getBoats().Count;
                AppView.renderCompactListElement(member, numberOfBoats);
            }

            AppView.waitForUserToRead();
        }
        private void doRenderVerboseListOfMembers()
        {
            AppView.renderListTitle(AppStrings.renderVerboseListOfMembersTitle);
            var members = MemberDAL.getMembers();

            foreach (var member in members)
            {
                AppView.renderVerboseListElement(member);
                BoatView.renderLongInformationAboutBoatsByMember(member);
                AppView.renderDivider();
            }

            AppView.waitForUserToRead();
        }
    }
}
