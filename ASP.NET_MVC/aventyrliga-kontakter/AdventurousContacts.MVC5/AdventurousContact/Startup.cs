using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(AdventurousContact.Startup))]
namespace AdventurousContact
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
        }
    }
}
