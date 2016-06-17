class CreateDomains < ActiveRecord::Migration
  def change
    create_table :domains do |t|
      t.references :user

      t.string "domain_name", :limit => 50
      t.string "description", :limit => 50
      t.string "authentication_token"
      t.timestamps null: false
    end
  end
end
