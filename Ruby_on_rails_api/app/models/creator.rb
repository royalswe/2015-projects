class Creator < ActiveRecord::Base
  has_many :stories, dependent: :destroy

  before_create :generate_authentication_token

  before_save { self.username = username.downcase }
  validates :username,
            length: { maximum: 20, minimum: 2 }

  before_save { self.email = email.downcase }

  VALID_EMAIL_REGEX = /\A[\w+\-.]+@[a-z\d\-.]+\.[a-z]+\z/i
  validates :email,
            presence: true,
            length: { maximum: 50 },
            format: { with: VALID_EMAIL_REGEX },
            uniqueness: { case_sensitive: false }

  has_secure_password
  validates :password, presence: true, length: { minimum: 3 }, allow_nil: true

  def generate_authentication_token
    loop do
      self.auth_token = SecureRandom.base64(64)
      break unless Creator.find_by(auth_token: auth_token)
    end
  end
end
