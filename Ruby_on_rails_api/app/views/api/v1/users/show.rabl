collection @user

attributes :username, :email, :created_at

child :stories do
  attribute :id, :creator_id, :title, :description, :address, :longitude, :latitude, :created_at, :tags
end