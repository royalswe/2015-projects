using System;
using System.Collections.Generic;
using System.Linq;
using System.Xml.Linq;

namespace Workshop_2.Model
{
    class BoatDAL
    {
        public bool add(Member member, Boat boat)
        {
            try
            {
                XDocument xElement = XDocument.Load(XMLFileInfo.Path);

                XElement particularMember = xElement.Element(XMLFileInfo.Members).Elements(XMLFileInfo.Member)
                                    .Where(a => a.Element(XMLFileInfo.ID).Value == member.MemberID.ToString())
                                    .Last();
                if (particularMember != null)
                    particularMember.Add(createBoat(boat));
                xElement.Save(XMLFileInfo.Path);

                return true;
            }
            catch (Exception)
            {
                return false;
            }

        }

        public bool updateBoat(Member member, int boatsToBeSkipped, Boat boatToAdd)
        {
            try
            {
                XElement xElement = XElement.Load(XMLFileInfo.Path);

                XElement memberToUpdate = (from Member in xElement.Elements(XMLFileInfo.Member)
                                               where (string)Member.Element(XMLFileInfo.ID) == member.MemberID.ToString()
                                               select Member).First();

                XElement boat = memberToUpdate.Elements(XMLFileInfo.Boat)
                    .Skip(boatsToBeSkipped)
                    .Take(1)
                    .First();

                boat.ReplaceWith(createBoat(boatToAdd));
                
                xElement.Save(XMLFileInfo.Path);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public List<Boat> getBoatsByMember(Member member)
        {
            List<Boat> boats = new List<Boat>();

            XElement xElement = XElement.Load(XMLFileInfo.Path);

            var memberInfo = from Member in xElement.Elements(XMLFileInfo.Member)
                             where (string)Member.Element(XMLFileInfo.ID) == member.MemberID.ToString()
                             select Member;

            XElement memberToGetBoatsFrom = memberInfo.First();
            
            foreach (XElement boat in memberToGetBoatsFrom.Elements(XMLFileInfo.Boat))
            {
                BoatType type = (BoatType)Enum.Parse(typeof(BoatType), boat.Attribute(XMLFileInfo.Type).Value);
                var boatToBeAdded = new Boat(type, int.Parse(boat.Value));
                boats.Add(boatToBeAdded);
            }

            boats.TrimExcess();

            return boats;
        }

        public bool removeBoat(Member member, int boat)
        {
            try
            {
                XElement xElement = XElement.Load(XMLFileInfo.Path);

                xElement.Descendants(XMLFileInfo.Member)
                    .Where(a => a.Element(XMLFileInfo.ID).Value == member.MemberID.ToString())
                    .SelectMany(a => a.Elements(XMLFileInfo.Boat))
                    .Skip(boat).Take(1)
                    .Remove();

                xElement.Save(XMLFileInfo.Path);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        private XElement createBoat(Boat boat)
        {
            return new XElement(XMLFileInfo.Boat, boat.Length, new XAttribute(XMLFileInfo.Type, boat.Type));
        }
    }
}
