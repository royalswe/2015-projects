using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Xml;
using System.Xml.Linq;

namespace Workshop_2.Model
{
    class MemberDAL
    {
        public bool saveMember(Member member)
        {
            if (member.MemberID != 0)
            {
                return updateMember(member);
            }
            else
            {
                return addMember(member);
            }
        }

        private bool addMember(Member member)
        {
            try
            {
                // Check if file exist or if the file length is shorter than 55 // 55 is the length of the xml version info in the file
                if (!File.Exists(XMLFileInfo.Path) || new FileInfo(XMLFileInfo.Path).Length < 55)
                {
                    XmlWriterSettings xmlWriterSettings = new XmlWriterSettings();
                    xmlWriterSettings.Indent = true;
                    xmlWriterSettings.NewLineOnAttributes = true;
                    using (XmlWriter xmlWriter = XmlWriter.Create(XMLFileInfo.Path, xmlWriterSettings))
                    {
                        xmlWriter.WriteStartDocument();
                        xmlWriter.WriteStartElement(XMLFileInfo.Members);

                        xmlWriter.WriteStartElement(XMLFileInfo.Member);
                        xmlWriter.WriteElementString(XMLFileInfo.ID, XMLFileInfo.FirstID);
                        xmlWriter.WriteElementString(XMLFileInfo.Name, member.Name);
                        xmlWriter.WriteElementString(XMLFileInfo.SocialSecurityNumber, member.SocialSecurityNumber);
                        xmlWriter.WriteEndElement();

                        xmlWriter.WriteEndElement();
                        xmlWriter.WriteEndDocument();
                        xmlWriter.Flush();
                        xmlWriter.Close();
                    }
                }
                else
                {
                    XElement xElement = XElement.Load(XMLFileInfo.Path);
                    int ID = int.Parse((string)xElement.Descendants(XMLFileInfo.ID).FirstOrDefault());
                    ID++;
                    xElement.AddFirst(createMember(ID, member));
                    xElement.Save(XMLFileInfo.Path);
                }
                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        private bool updateMember(Member memberToBeUpdated)
        {
            try
            {
                var ID = memberToBeUpdated.MemberID;

                var currentMember = getMemberByID(ID);
                if (String.IsNullOrWhiteSpace(memberToBeUpdated.Name))
                    memberToBeUpdated.Name = currentMember.Name;
                if (String.IsNullOrWhiteSpace(memberToBeUpdated.SocialSecurityNumber))
                    memberToBeUpdated.SocialSecurityNumber = currentMember.SocialSecurityNumber;

                var oldMember = createMember(currentMember);
                var updatedMember = createMember(memberToBeUpdated);

                XElement xElement = XElement.Load(XMLFileInfo.Path);

                XElement memberToBeReplaced = (from Member in xElement.Elements(XMLFileInfo.Member)
                                              where (string)Member.Element(XMLFileInfo.ID) == ID.ToString()
                                              select Member).First();

                foreach (XElement element in memberToBeReplaced.Elements(XMLFileInfo.Boat))
                    updatedMember.Add(element);

                memberToBeReplaced.ReplaceWith(updatedMember);

                xElement.Save(XMLFileInfo.Path);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public bool validateMemberID(int IdToValidate)
        {
            try
            {
                XElement xElement = XElement.Load(XMLFileInfo.Path);
                IEnumerable<XElement> members = xElement.Elements();
                foreach (var member in members)
                {
                    if (member.Element(XMLFileInfo.ID).Value == IdToValidate.ToString())
                        return true;
                }
            }
            catch (Exception)
            {
                
            }

            return false;
        }

        public Member getMemberByID(int ID)
        {
            XElement xElement = XElement.Load(XMLFileInfo.Path);

            var memberInfo = from Member in xElement.Elements(XMLFileInfo.Member)
                                where (string)Member.Element(XMLFileInfo.ID) == ID.ToString()
                                select Member;

            var memberNames = memberInfo.Elements(XMLFileInfo.Name);
            XElement memberName = memberNames.First();

            var memberSSNs = memberInfo.Elements(XMLFileInfo.SocialSecurityNumber);
            XElement memberSSN = memberSSNs.First();

            var memberIDs = memberInfo.Elements(XMLFileInfo.ID);
            XElement memberID = memberIDs.First();

            var member = new Member(memberName.Value, memberSSN.Value, int.Parse(memberID.Value));

            return member;
        }

        public bool removeMember(int memberID)
        {
            try
            {
                if (!validateMemberID(memberID))
                    throw new KeyNotFoundException();

                XElement xElement = XElement.Load(XMLFileInfo.Path);

                xElement.Descendants(XMLFileInfo.Member)
                    .Where(aa => aa.Element(XMLFileInfo.ID).Value == memberID.ToString())
                    .Remove();

                xElement.Save(XMLFileInfo.Path);
                return true;
            }
            catch (Exception)
            {

                return false;
            }
        }


        /// <summary>
        /// Creates list of all members. 
        /// </summary>
        /// <returns>List of members.</returns>
        public List<Member> getMembers()
        {
            var memberList = new List<Member>();

            try
            {
                XElement xElement = XElement.Load(XMLFileInfo.Path);

                IEnumerable<XElement> members = xElement.Elements();

                foreach (var member in members)
                {
                    memberList.Add(new Member((string)member.Element(XMLFileInfo.Name), 
                        (string)member.Element(XMLFileInfo.SocialSecurityNumber), 
                        (int)member.Element(XMLFileInfo.ID)));      
                }

                memberList.TrimExcess();

                
            }
            catch (Exception)
            {

            }

            return memberList;
        }

        private XElement createMember(Member member)
        {
            return createMember(member.MemberID, member);
        }
        private XElement createMember(int ID, Member member)
        {
            return new XElement(XMLFileInfo.Member,
                           new XElement(XMLFileInfo.ID, ID),
                           new XElement(XMLFileInfo.Name, member.Name),
                           new XElement(XMLFileInfo.SocialSecurityNumber, member.SocialSecurityNumber));
        }
    }
}
