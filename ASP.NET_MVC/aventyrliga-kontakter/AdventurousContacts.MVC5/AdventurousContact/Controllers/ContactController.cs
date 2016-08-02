using AdventurousContact.Models;
using AdventurousContact.Models.Repositories;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;

namespace AdventurousContact.Controllers
{
    public class ContactController : Controller
    {
        private IRepository _repository;

        public ContactController() : this(new Repository()) { }
        public ContactController(IRepository repository)
        {
            _repository = repository;
        }
        // GET: Contact
        public ActionResult Index()
        {
            return View(_repository.GetLastContacts());
        }

        // GET: /Contact/Create
        public ActionResult Create()
        {
            return View("Create");
        }

        // POST: /Contact/create
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "FirstName, LastName, EmailAddress")] Contact contact)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    _repository.Add(contact);
                    _repository.Save();
                    TempData["success"] = String.Format(
                        "{0} {1} ({2}) was successfully created", contact.FirstName, contact.LastName, contact.EmailAddress);

                    return RedirectToAction("Index");
                }
                catch (DataException)
                {
                    TempData["error"] = "Create was unsuccessful.";
                }
            }
            return View();
        }

        // GET: /Contact/Edit/int id
        public ActionResult Edit(int? id)
        {
            if (!id.HasValue)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            var contact = _repository.GetContactById(id.Value);

            if (contact == null)
            {
                return View("NoContactFound");
            }

            return View(contact);
        }

        // POST: /Contact/Edit/contact id
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit(Contact contact)
        {
            if (contact == null)
            {
                return View("NoContactFound");
            }

            // protect against overposting
            if (TryUpdateModel(contact, new string[] { "FirstName, LastName, EmailAddress" }))
            {
                try
                {
                    _repository.Update(contact);
                    _repository.Save();
                    TempData["success"] = String.Format(
                        "{0} {1} ({2}) was successfully saved", contact.FirstName, contact.LastName, contact.EmailAddress);

                    return RedirectToAction("Index");
                }
                catch (DataException)
                {
                    TempData["error"] = "Try to change user failed.";
                }
            }

            return View(contact);
        }

        // GET: /Contact/Delete/int id
        public ActionResult Delete(int? id)
        {
            if (!id.HasValue)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            var contact = _repository.GetContactById(id.Value);

            if (contact == null) { return HttpNotFound(); }

            return View(contact);
        }

        // POST: /Contact/Delete/int id
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Delete(int id)
        {
            try
            {
                var contactToDelete = new Contact { ContactID = id };
                _repository.Delete(contactToDelete);
                _repository.Save();
                TempData["success"] = "Delete was successful.";

                return RedirectToAction("Index");
            }
            catch (DataException)
            {
                if (id <= 19977)
                {
                    TempData["error"] = "You are not allowed to delete this contact.";
                }
                else
                {
                    TempData["error"] = "Delete was unsuccessful.";
                }   
            }

            return RedirectToAction("Delete", new { id = id });
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                _repository.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}