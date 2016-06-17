collection @story
attributes :title, :description, :longitude, :latitude, :created_at, :latitude, :longitude, :address

#unless locals[:hide_username]
#node(:edit_story) { |stories| edit_story_url(stories) }

child(:creator) { attributes :username, :admin }

child :tags do
  attribute :created_at, :name
end