class Story < ActiveRecord::Base
  belongs_to :user
  belongs_to :creator
  has_many :story_tags, dependent: :destroy
  has_many :tags, through: :story_tags

  default_scope -> { order(created_at: :desc) }
  validates :user_id, presence: true
  
  validates :title,
            :presence => {:message => "You have to give a title"},
             length: { maximum: 50 }
            
  validates :description,
            :presence => {:message => "You have to give a description"},
             length: { maximum: 200 }

  # fetch coordinates from address if it is present.
  geocoded_by :address
  after_validation :geocode, :if => :address_changed?

  # search for stories by title or description if present
  def self.search(params)
    story = order('created_at DESC') # note: default is all, just sorted
    story = where('title LIKE ? OR description LIKE ?', "%#{params[:search]}%", "%#{params[:search]}%") if params[:search].present?
    story
  end

  ###################################################
  ## Code bellow is not for the API, view specific ##
  ###################################################

  # Insert each tag in db separated with comma.
  def all_tags=(names)
    self.tags = names.split(",").map do |name|
      Tag.where(name: name.strip).first_or_create!
    end
  end
  # Render all the tags separated by commas.
  def all_tags
    self.tags.map(&:name).join(", ")
  end

end
