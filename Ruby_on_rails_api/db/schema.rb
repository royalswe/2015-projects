# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended that you check this file into your version control system.

ActiveRecord::Schema.define(version: 20160131230057) do

  create_table "creators", force: :cascade do |t|
    t.string   "username",        limit: 20
    t.string   "email",           limit: 50
    t.string   "password_digest"
    t.string   "auth_token"
    t.boolean  "admin",                      default: false
    t.datetime "created_at",                                 null: false
    t.datetime "updated_at",                                 null: false
  end

  create_table "domains", force: :cascade do |t|
    t.integer  "user_id"
    t.string   "domain_name",          limit: 50
    t.string   "description",          limit: 50
    t.string   "authentication_token"
    t.datetime "created_at",                      null: false
    t.datetime "updated_at",                      null: false
  end

  create_table "stories", force: :cascade do |t|
    t.integer  "user_id"
    t.integer  "creator_id"
    t.string   "title",       limit: 50
    t.string   "address"
    t.text     "description"
    t.float    "longitude"
    t.float    "latitude"
    t.datetime "created_at",             null: false
    t.datetime "updated_at",             null: false
  end

  add_index "stories", ["creator_id"], name: "index_stories_on_creator_id"
  add_index "stories", ["user_id"], name: "index_stories_on_user_id"

  create_table "story_tags", force: :cascade do |t|
    t.integer  "story_id"
    t.integer  "tag_id"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
  end

  add_index "story_tags", ["story_id"], name: "index_story_tags_on_story_id"
  add_index "story_tags", ["tag_id"], name: "index_story_tags_on_tag_id"

  create_table "tags", force: :cascade do |t|
    t.string   "name"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
  end

  add_index "tags", ["name"], name: "index_tags_on_name"

  create_table "users", force: :cascade do |t|
    t.string   "username",        limit: 20
    t.string   "email",           limit: 50
    t.string   "password_digest"
    t.datetime "created_at",                                 null: false
    t.datetime "updated_at",                                 null: false
    t.boolean  "admin",                      default: false
  end

end
