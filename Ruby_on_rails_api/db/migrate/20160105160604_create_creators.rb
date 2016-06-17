class CreateCreators < ActiveRecord::Migration
  def change
    create_table :creators do |t|
      t.string "username", :limit => 20
      t.string "email", :limit => 50
      t.string "password_digest"
      t.string "auth_token"
      t.boolean "admin", default: false

      t.timestamps null: false
    end
  end
end
