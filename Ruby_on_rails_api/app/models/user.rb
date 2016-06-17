class User < ActiveRecord::Base
  has_many :stories, dependent: :destroy
  has_many :domains, dependent: :destroy

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


  # Make sure password is given when update user
  cattr_reader :current_password
  def update_with_password(user_params)
    current_password = user_params.delete(:current_password)

    if self.authenticate(current_password)
      self.update(user_params)
      true
    else
      self.errors.add(:current_password, current_password.blank? ? :blank : :invalid)
      false
    end
  end

end
