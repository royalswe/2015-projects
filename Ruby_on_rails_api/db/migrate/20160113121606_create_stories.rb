class CreateStories < ActiveRecord::Migration
  def change
    create_table :stories do |t|
      t.references :user, index: true
      t.references :creator, index: true, foreign_key: true

      t.string "title", :limit => 50
      t.string "address"
      t.text "description"
      t.float "longitude"
      t.float "latitude"
      t.timestamps null: false
    end

  end
end
