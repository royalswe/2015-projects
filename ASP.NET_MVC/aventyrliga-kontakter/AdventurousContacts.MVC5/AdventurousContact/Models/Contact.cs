using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;

namespace AdventurousContact.Models
{
    [MetadataType(typeof(Contact_Metadat))]
    public partial class Contact
    {
        public class Contact_Metadat
        {
            [Required]
            [MaxLength(50)]
            [DisplayName("First Name")]
            public string FirstName { get; set; }
            [Required]
            [MaxLength(50)]
            [DisplayName("Last Name")]
            public string LastName { get; set; }
            [Required]
            [MaxLength(50)]
            [DataType(DataType.EmailAddress)]
            [EmailAddress]
            [DisplayName("E-mail address")]
            public string EmailAddress { get; set; }
        }
    }
}