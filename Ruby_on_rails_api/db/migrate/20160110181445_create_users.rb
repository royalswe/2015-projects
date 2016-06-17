class CreateUsers < ActiveRecord::Migration
  def change
    create_table :users do |t|
      t.string "username", :limit => 20
      t.string "email", :limit => 50
      t.string "password_digest"

      t.timestamps null: false
    end
  end
end
